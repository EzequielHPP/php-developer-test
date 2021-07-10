<?php

use App\Http\v1\Controller\ArticleController;
use App\Http\v1\Controller\LandingController;

// Version 1 of the application routing
$app->group('/v1', function (\Slim\Routing\RouteCollectorProxy $group) {
    $group->get('', LandingController::class . ':v1')->setName('v1-homepage');

    $group->get('/articles', ArticleController::class . ':index')->setName('article-list');
    $group->get('/articles/{id}', ArticleController::class . ':show')->setName('article-single');
});

/** @noinspection PhpUndefinedVariableInspection */
$app->get('/[{path:.*}]', LandingController::class . ':index')->setName('hello-world');
