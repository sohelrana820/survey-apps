<?php

use App\Controller\DefaultController;
use App\Controller\OrdersController;
use App\Controller\ProductsController;

// Default pages
$app->get('/', DefaultController::class . ':home');
$app->get('/robots', DefaultController::class . ':robotsTXT');
$app->get('/sitemap', DefaultController::class . ':sitemapXML');
$app->get('/download', DefaultController::class . ':download');

// Routes of pages
$app->group('/pages', function () use ($app) {
    $app->get('/faqs', DefaultController::class . ':faqs');
    $app->get('/privacy-policy', DefaultController::class . ':privacy');
    $app->get('/terms-and-conditions', DefaultController::class . ':termsAndConditions');
    $app->get('/contact-us', DefaultController::class . ':contact');
    $app->post('/contact-us', DefaultController::class . ':contactUs');
});

// Routes of error
$app->group('/error', function () use ($app) {
    $app->get('/404', DefaultController::class . ':notFoundPage');
    $app->get('/500', DefaultController::class . ':serverErrorPage');
    $app->get('/403', DefaultController::class . ':forbiddenPage');
});

// Routes of products
$app->group('/products', function () use ($app) {
    $app->get('', ProductsController::class . ':products');
    $app->get('/{slug}', ProductsController::class . ':productDetails');
});

// Routes of orders
$app->group('/orders', function () use ($app) {
    $app->post('', OrdersController::class . ':order');
    $app->post('/send-links', OrdersController::class . ':sendLinks');
});
