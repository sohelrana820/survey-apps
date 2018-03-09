<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/', \App\Controller\HomeController::class . ':home');
$app->get('/signup', \App\Controller\AuthController::class . ':signupPage')->add(new \App\Middleware\AuthMiddleware());
$app->post('/signup', \App\Controller\AuthController::class . ':signup')->add(new \App\Middleware\AuthMiddleware());
