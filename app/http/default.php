<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/', \App\Controller\HomeController::class . ':home')->add(new \App\Middleware\AuthMiddleware());
