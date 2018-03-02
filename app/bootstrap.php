<?php

use Monolog\Handler\StreamHandler;
use Slim\Container;

// Getting application container;
$container = $app->getContainer();
$settings = $container->get('settings');

/**
 * @param Container $container
 * @return \Slim\Views\Twig
 * @throws \Interop\Container\Exception\ContainerException
 *
 * Configuring application view files [twig]
 */
$container['view'] = function (Container $container) {
    $settings = $container->get('settings');
    $view = new \Slim\Views\Twig($settings['view']['template_path'], $settings['view']['twig']);
    $view->addExtension(new \Slim\Views\TwigExtension($container['router'], $container['request']->getUri()));
    $view->addExtension(new Twig_Extension_Debug());
    $twigExtra = $view->getEnvironment();
    $twigExtra->addGlobal('session', $_SESSION);
    $twigExtra->addGlobal('config', $settings);
    return $view;
};

/**
 * @param Container $container
 * @return mixed
 * @throws \Interop\Container\Exception\ContainerException
 */
$container['config'] = function (Container $container) {
    return $container->get('settings');
};

/**
 * @return \Slim\Flash\Messages
 */
$container['flash'] = function () {
    return new Slim\Flash\Messages();
};

/**
 * @param Container $container
 * @return \Monolog\Logger
 * @throws Exception
 */
$container['logger'] = function (Container $container) {
    $config = $container['config'];
    $logger = new Monolog\Logger($config['logger']['name']);
    $logger->pushProcessor(new \Monolog\Processor\ProcessIdProcessor());
    $logger->pushProcessor(new \Monolog\Processor\PsrLogMessageProcessor());
    $logger->pushProcessor(new \Monolog\Processor\WebProcessor());
    $logger->pushHandler(new StreamHandler($config['logger']['path'], $config['logger']['level']));
    return $logger;
};


// Loading application routes
require ROOT_DIR . DIRECTORY_SEPARATOR . 'app/routes.php';