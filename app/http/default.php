<?php

$app->get('/', \App\Controller\HomeController::class . ':home');
$app->get('/products', \App\Controller\ProductsController::class . ':products');
$app->get('/products/{slug}', \App\Controller\ProductsController::class . ':productDetails');
$app->get('/404', \App\Controller\HomeController::class . ':notFoundPage');
$app->get('/500', \App\Controller\HomeController::class . ':ServerErrorPage');

// Routes of orders
$app->get('/back_to', \App\Controller\OrdersController::class . ':backTo');

