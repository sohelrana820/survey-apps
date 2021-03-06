<?php
use App\Controller\AuthController;
use App\Controller\SurveyController;

$app->get('/', AuthController::class . ':loginPage')->add(\App\Middleware\AuthMiddleware::class);
$app->get('/login', AuthController::class . ':loginPage');
$app->post('/login', AuthController::class . ':login');
$app->get('/logout', AuthController::class . ':logout');

$app->group('/survey', function () use ($app) {
    $app->get('', SurveyController::class . ':home');
    $app->get('/start', SurveyController::class . ':start');
    $app->post('/collect', SurveyController::class . ':collect');
    $app->get('/complete', SurveyController::class . ':complete');
    $app->get('/list', SurveyController::class . ':listPage');
    $app->get('/view[/{id}]', SurveyController::class . ':view');
    $app->get('/change', SurveyController::class . ':change');
    $app->get('/users', SurveyController::class . ':users');
    $app->get('/questions', SurveyController::class . ':questions');
    $app->get('/download', SurveyController::class . ':download');
    $app->get('/clear', SurveyController::class . ':clear');
    $app->get('/menu', SurveyController::class . ':menu');
})->add(\App\Middleware\AuthMiddleware::class);
