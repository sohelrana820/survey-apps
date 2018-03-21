<?php

$app->get('/', \App\Controller\HomeController::class . ':home');
$app->get('/products', \App\Controller\ProductsController::class . ':products');
$app->get('/products/{slug}', \App\Controller\ProductsController::class . ':productDetails');
$app->get('/404', \App\Controller\HomeController::class . ':notFoundPage');
$app->get('/500', \App\Controller\HomeController::class . ':serverErrorPage');
$app->get('/403', \App\Controller\HomeController::class . ':forbiddenPage');
$app->get('/download', \App\Controller\OrdersController::class . ':download');

// Routes of orders
$app->post('/orders', \App\Controller\OrdersController::class . ':order');
$app->post('/orders/send-links', \App\Controller\OrdersController::class . ':sendLinks');

