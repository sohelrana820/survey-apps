<?php

// Default pages
$app->get('/', \App\Controller\DefaultController::class . ':home');
$app->get('/robots.txt', \App\Controller\DefaultController::class . ':robotsTXT');
$app->get('/sitemap', \App\Controller\DefaultController::class . ':sitemapXML');

// Routes of pages
$app->group('/pages', function () use ($app) {
    $app->get('/faqs', \App\Controller\DefaultController::class . ':faqs');
    $app->get('/privacy-policy', \App\Controller\DefaultController::class . ':privacy');
    $app->get('/terms-and-conditions', \App\Controller\DefaultController::class . ':termsAndConditions');
    $app->get('/contact-us', \App\Controller\DefaultController::class . ':contact');
    $app->post('/contact-us', \App\Controller\DefaultController::class . ':contactUs');
    $app->get('/download', \App\Controller\DefaultController::class . ':download');
});

// Routes of error
$app->group('/error', function () use ($app) {
    $app->get('/404', \App\Controller\DefaultController::class . ':notFoundPage');
    $app->get('/500', \App\Controller\DefaultController::class . ':serverErrorPage');
    $app->get('/403', \App\Controller\DefaultController::class . ':forbiddenPage');
});

// Routes of products
$app->group('/products', function () use ($app) {
    $app->get('', \App\Controller\ProductsController::class . ':products');
    $app->get('/{slug}', \App\Controller\ProductsController::class . ':productDetails');
});

// Routes of orders
$app->group('/orders', function () use ($app) {
    $app->post('', \App\Controller\OrdersController::class . ':order');
    $app->post('/send-links', \App\Controller\OrdersController::class . ':sendLinks');
});
