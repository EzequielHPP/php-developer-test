<?php

namespace App\Http\v1\Controller;

use App\Http\v1\Service\ArticleService;
use App\System\Exception\ArticleNotFound;
use App\System\Reply;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ArticleController extends Reply
{

    /**
     * Display a listing of the article.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function index(Request $request, Response $response): Response
    {
        try {
            $articles = (new ArticleService())->getAllArticles();

            return $this->send($response, $articles);
        } catch (\Throwable $exception) {
            return $this->abort($response, $exception->getMessage(), 503);
        }
    }

    /**
     * Display the specified article.
     *
     * @param Request $request
     * @param Response $response
     * @param $arguments
     * @return Response
     */
    public function show(Request $request, Response $response, $arguments): Response
    {
        $article = [];
        try {
            if (array_key_exists('id', $arguments)) {
                $article = (new ArticleService())->getArticle((int)$arguments['id']);
            }
            if (empty($article)) {
                throw new ArticleNotFound();
            }
        } catch (ArticleNotFound $exception) {
            return $this->abort($response, $exception->getMessage(), 404);
        } catch (\Throwable $exception) {
            return $this->abort($response, $exception->getMessage(), 503);
        }
        return $this->send($response, $article);
    }
}
