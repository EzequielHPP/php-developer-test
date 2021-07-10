<?php

use Tests\TestCase;

class ArticleServiceTest extends TestCase
{
    private $service;
    private $mockEntries;

    protected function setUp() : void {
        parent::setUp();
        $sep = DIRECTORY_SEPARATOR;
        $file = __DIR__.$sep.'Models'.$sep.'articles.json';
        $this->service = (new \App\Http\v1\Service\ArticleService());

        $articles = json_decode(file_get_contents($file));
        shuffle($articles);
        $this->mockEntries = array_values($articles);
    }

    public function testGetAllArticles(): void
    {
        $articles = $this->service->getAllArticles();

        self::assertIsArray($articles);
    }

    public function testNotEmptyAllArticles(): void
    {
        $articles = $this->service->getAllArticles();

        self::assertNotEmpty($articles);
    }

    public function testGetArticle(): void
    {
        $article = $this->service->getArticle($this->mockEntries[0]->id);

        self::assertIsObject($article);
    }

    public function testId(): void
    {
        $article = $this->service->getArticle($this->mockEntries[0]->id);
        self::assertIsObject($article);
    }

    public function testTitle(): void
    {
        $article = $this->service->getArticle($this->mockEntries[0]->id);
        self::assertObjectHasAttribute('title', $article);
        self::assertIsString($article->title);
    }

    public function testSlug(): void
    {
        $article = $this->service->getArticle($this->mockEntries[0]->id);
        self::assertObjectHasAttribute('slug', $article);
        self::assertIsString($article->slug);
    }

    public function testContent(): void
    {
        $article = $this->service->getArticle($this->mockEntries[0]->id);
        self::assertObjectHasAttribute('content', $article);
    }

    public function testGetInvalidArticle(): void
    {
        try {
            $articles = $this->service->getArticle(0);
            self::fail('No exception thrown. Expecting ArticleNotFound exception');
        } catch (\App\System\Exception\ArticleNotFound $exception){
            self::assertTrue(true);
        } catch (\Throwable $exception){
            self::fail('Not the correct exception thrown. Expecting ArticleNotFound exception');
        }
    }

}
