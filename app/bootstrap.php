<?php

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

// Loading application routes
require ROOT_DIR . DIRECTORY_SEPARATOR . 'app/routes.php';