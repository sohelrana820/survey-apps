<?php
use App\Controller\AuthController;
use App\Controller\SurveyController;

$app->get('/login', AuthController::class . ':loginPage');
$app->post('/login', AuthController::class . ':login');

$app->group('/survey', function () use ($app) {
    $app->get('/start', SurveyController::class . ':start');
    $app->post('/collect', SurveyController::class . ':collect');
})->add(\App\Middleware\AuthMiddleware::class);
