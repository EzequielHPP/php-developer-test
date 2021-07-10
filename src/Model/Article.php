<?php

namespace App\Model;

use App\System\BaseModel;

class Article extends BaseModel
{
    protected string $model = 'Articles';
    protected string $nameSpace;

    public function __construct()
    {
        // Namespace is set so we can set entries as this model from the BaseModel
        $this->nameSpace = __NAMESPACE__;
        parent::__construct();
    }
}
