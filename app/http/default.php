<?php


$app->get('/', \App\Controller\HomeController::class . ':home');
$app->get('/signup', \App\Controller\AuthController::class . ':signupPage');
$app->post('/signup', \App\Controller\AuthController::class . ':signup');
$app->get('/login', \App\Controller\AuthController::class . ':loginPage');
$app->post('/login', \App\Controller\AuthController::class . ':login');
