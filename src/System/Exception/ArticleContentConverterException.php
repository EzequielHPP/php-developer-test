<?php


namespace App\System\Exception;


class ArticleContentConverterException extends BaseException
{
    public function __construct($articleId, $message)
    {
        parent::__construct(__('article_converter_error', ['id' => $articleId, 'message' => $message]));
    }
}
