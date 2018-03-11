<?php


$app->get('/', \App\Controller\HomeController::class . ':home');
$app->get('/404', \App\Controller\HomeController::class . ':notFoundPage');
$app->get('/500', \App\Controller\HomeController::class . ':ServerErrorPage');

