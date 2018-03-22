<?php

// Home page
$app->get('/', \App\Controller\HomeController::class . ':home');
$app->get('/download', \App\Controller\HomeController::class . ':download');

// Routes of error
$app->group('/error', function () use ($app){
    $app->get('/404', \App\Controller\HomeController::class . ':notFoundPage');
    $app->get('/500', \App\Controller\HomeController::class . ':serverErrorPage');
    $app->get('/403', \App\Controller\HomeController::class . ':forbiddenPage');
});

// Routes of products
$app->group('/products', function () use ($app){
    $app->get('/', \App\Controller\ProductsController::class . ':products');
    $app->get('/{slug}', \App\Controller\ProductsController::class . ':productDetails');
});

// Routes of orders
$app->group('/orders', function () use ($app){
    $app->post('/', \App\Controller\OrdersController::class . ':order');
    $app->post('/send-links', \App\Controller\OrdersController::class . ':sendLinks');
});


