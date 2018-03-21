<?php

$app->get('/', \App\Controller\HomeController::class . ':home');
$app->get('/products', \App\Controller\ProductsController::class . ':products');
$app->get('/products/{slug}', \App\Controller\ProductsController::class . ':productDetails');
$app->get('/404', \App\Controller\HomeController::class . ':notFoundPage');
$app->get('/500', \App\Controller\HomeController::class . ':serverErrorPage');
$app->get('/403', \App\Controller\HomeController::class . ':forbiddenPage');
$app->get('/download', \App\Controller\OrdersController::class . ':download');

// Routes of orders
$app->post('/order', \App\Controller\OrdersController::class . ':order');
$app->get('/order/cancel', \App\Controller\OrdersController::class . ':cancelOrder');
$app->get('/order/confirm', \App\Controller\OrdersController::class . ':confirmOrder');
$app->get('/back_to', \App\Controller\OrdersController::class . ':backTo');
$app->get('/email', \App\Controller\OrdersController::class . ':email');

