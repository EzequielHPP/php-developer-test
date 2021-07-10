<?php


namespace App\System\Exception;


class ModelFileNotFound extends BaseException
{
    public function __construct($model)
    {
        parent::__construct(__('model_not_found', ['model' => $model]));
    }
}
