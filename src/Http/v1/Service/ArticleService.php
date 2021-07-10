<?php


namespace App\Http\v1\Service;


use App\Helpers\DomConverter;
use App\Helpers\StringHelper;
use App\Model\Article;
use App\System\Exception\ArticleContentConverterException;
use App\System\Exception\ArticleNotFound;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Options;

class ArticleService
{
    private $articleModel;

    public function __construct()
    {
        // In a real life scenario this should be dependency injection to make it loosely coupled
        // Then we can have multiple Models using the same service to read/process various types of articles
        $this->articleModel = new Article();
    }

    /**
     * Get all the articles from the DB
     * After retrieving them ask the sanitizer to cleanup the entry values
     *
     * @return array|mixed|null
     * @throws ArticleContentConverterException
     */
    public function getAllArticles()
    {
        $articles = $this->articleModel->get();
        foreach ($articles as $index => $article) {
            // If we want to keep the content for the "get all" then we remove / set to true the second parameter
            $articles[$index] = $this->sanitize($article, false);
        }
        return $articles;
    }

    /**
     * This sanitizer does:
     * - Title - Strip tags and HTML-encode double and single quotes, optionally strip or encode special characters.
     * - Slug - Remove all characters except letters, digits and some special characters
     * - Content - Asks convertHtmlToObject to parse the html content to an object
     *
     * @param Article $article - Article model
     * @param Bool $keepContent - Keep the content on the output object?
     * @return Article
     * @throws ArticleContentConverterException
     */
    private function sanitize(Article $article, bool $keepContent = true): Article
    {
        $article->id = (int)$article->id;
        $article->title = filter_var($article->title, FILTER_SANITIZE_STRING) ?? '';
        $article->slug = filter_var($article->slug, FILTER_SANITIZE_URL) ?? '';
        if ($keepContent) {
            if (is_array($article->content)) {
                $article->content = '';
            }

            $this->convertHtmlToObject($article);
        } else {
            unset($article->content);
        }

        return $article;
    }

    /**
     * Convert HTML string to objectified array of elements
     *
     * @param Article $article
     * @return void
     * @throws ArticleContentConverterException
     */
    private function convertHtmlToObject(Article $article): void
    {
        $output = [];

        try {
            // Set the options for the interpreter to not replace special characters and to keep line breaks
            // and keep the scripts
            $interpreterOptions = new Options();
            $interpreterOptions->setPreserveLineBreaks(true);
            $interpreterOptions->setHtmlSpecialCharsDecode(false);
            $interpreterOptions->setRemoveScripts(false);

            // Convert the html string to Dom Parser
            $dom = (new Dom());

            $dom->loadStr(StringHelper::cleanHtml($article->content), $interpreterOptions);
            // Iterate through the children / nodes and convert them to the expected output
            $output = $this->iterateChildren($dom);
        } catch (\Throwable $exception) {
            throw new ArticleContentConverterException($article->id, $exception->getMessage());
        }
        $article->content = $output;
    }

    /**
     * Given a dom collection, iterate through children to transform into objects
     *
     * @param $dom
     * @return array
     */
    private function iterateChildren($dom): array
    {
        $output = [];
        foreach ($dom->getChildren() as $child) {
            $converted = $this->transformChildToObject($child);
            if (!empty($converted)) {
                $output[] = $converted;
            }
        }
        return $output;
    }

    /**
     * Asks DomConverter Helper to transform a given PHPHtmlParser Child into an array,
     * with type, [extra attributes], ?content
     *
     * @param $child
     * @return array|string[]
     */
    private function transformChildToObject($child): ?array
    {
        $tagName = $child->getTag()->name();
        $helper = new DomConverter();
        switch ($tagName) {
            case 'img':
                $output = $helper::convertImageTag($child);
                break;
            case 'h1':
            case 'h2':
            case 'h3':
            case 'h4':
            case 'h5':
            case 'h6':
                $output = $helper::convertHeaderTag($child);
                break;
            case 'strong':
            case 'b':
                $output = $helper::convertBoldTag($child);
                break;
            case 'div':
                $output = $helper::convertDivTag($child);
                break;
            case 'iframe':
                $output = $helper::convertIframeTag($child);
                break;
            case 'br':
                // If we have a paragraph followed by a BR it will lead to unwanted extra spaces on the code
                try {
                    if ($child->previousSibling()->getTag()->name() === 'p') {
                        return null;
                    }
                } catch (\Throwable $exception) {
                    return null;
                }
                $output = $helper::convertBreakline($child);
                break;
            default:
                $parent = $child->getParent();
                // P tags inside p tags is "illegal" so we convert it to plain text
                if ($parent->getTag()->name() === 'p') {
                    $output = $helper::convertText($child);
                } else {
                    $child->setTag('p');
                    $output = $helper::convertParagraph($child);
                }
                break;
        }
        $output['children'] = null;

        // Does the child have grand-children? then we need to process them as well
        // The content field can be emptied out here if desired.
        if ($this->hasChildren($child)) {
            //$output['content'] = null;
            $output['children'] = $this->iterateChildren($child);
        }
        return $output;
    }

    /**
     * Runs multiple checks for child to se if it has grand-children
     *
     * @param $child
     * @return bool
     */
    private function hasChildren($child): bool
    {
        if (($child instanceof Dom\Node\TextNode)) {
            return false;
        }

        // This is an edge case that it detects a child when the element is like this:
        // <h1>New York</h1>
        // So if the parent text content is the same as the grandchild then don't lie and say it has children
        if ($child->countChildren() === 1) {
            $grandChild = $child->firstChild();
            if ($grandChild->getTag()->name() === 'text' && strip_tags($child->innerHtml) === $grandChild->innerHtml) {
                return false;
            }
        }
        return $child->hasChildren();
    }

    /**
     * Find an article matching the id
     *
     * @param int $id
     * @return Article|null
     * @throws ArticleNotFound|ArticleContentConverterException
     */
    public function getArticle(int $id): ?Article
    {
        $article = $this->articleModel->find($id);

        if ($article === null || empty($article)) {
            throw new ArticleNotFound();
        }

        return $this->sanitize($article);
    }
}
