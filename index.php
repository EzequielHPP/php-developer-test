<?php

use Slim\Factory\AppFactory;

require_once __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

include_once __DIR__.'/src/System/Constants.php';
include_once __DIR__.'/src/System/Translator.php';

require __DIR__ . '/app/routes.php';

$app->run();
