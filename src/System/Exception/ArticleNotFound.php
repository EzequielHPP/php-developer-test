<?php


namespace App\System\Exception;


class ArticleNotFound extends BaseException
{
    public function __construct()
    {
        parent::__construct(__('article_not_found'));
    }
}
