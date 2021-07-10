<?php


namespace App\System\Exception;


class BaseException extends \Exception
{
    public function __construct($message = null) {
        parent::__construct($message);
    }
}
