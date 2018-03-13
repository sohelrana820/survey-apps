<?php

use Illuminate\Events\Dispatcher;
use Monolog\Handler\StreamHandler;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

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


    // Creating rating filter.
    $twigFilter = new Twig_SimpleFilter('rating_percentage', function ($rating, $totalRating) {
        $percentage = ($rating * 100) / $totalRating;
        return $percentage;
    });

    $truncateFilter = (new Twig_SimpleFilter('truncate', function($string, $length) {
        if(strlen($string) < $length)
            return $string;
        else
            return array_shift(str_split($string, $length)) . "...";
    }));

    $view->getEnvironment()->addFilter($twigFilter);
    $view->getEnvironment()->addFilter($truncateFilter);
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

/**
 * @param $container
 * @return Memcached|null
 */
$container['cache'] = function ($container) {
    if ($container['config']['enable_memcache']) {
        $config = $container['config'];
        $memcache = new Memcached();

        if(!$memcache) {
            $container->get('logger')->emergency("[memcache] server is down");
            return null;
        }

        $memcache->addServers($config['memcache']['hosts']);
        //If memcache server not found, then log this as emergency
        if ($memcache->getStats() === false) {
            $container->get('logger')->emergency("[memcache] server is down");
        }
        //Finish taking memcache server up log
        return $memcache;
    }

    return null;
};


/**
 * @param Container $container
 * @return Closure
 */
$container['notFoundHandler'] = function (Container $container) {
    return function (Request $request, Response $response) use ($container) {
        $container['logger']->error('Not Found', ['request_target' => $request->getRequestTarget()]);
        return $container['view']->render($response->withStatus(404), '404.twig');
    };
};

/**
 * @param Container $container
 * @return Closure
 */
$container['errorHandler'] = function (Container $container) {
    return function (Request $request, Response $response, Exception $exception) use ($container) {
        $container['logger']->error($exception->getMessage(), [$request->getQueryParams()]);
        $container['logger']->debug($exception->getTraceAsString(), [$request->getQueryParams()]);
        return $container['view']->render($response->withStatus(500), '500.twig');
    };
};

/**
 * @param Container $container
 * @return Closure
 */
/*$container['phpErrorHandler'] = function (Container $container) {
    return function (Request $request, Response $response) use ($container) {
        $container['logger']->error("[phpErrorHandler] 500 error caught");
        return $container['view']->render($response->withStatus(500), '500.twig');
    };
};*/


// Connecting to database
if ($container['config']['database_require']) {
    $databaseConf = $container['settings']['databases'];
    $capsule = new Illuminate\Database\Capsule\Manager();
    $capsule->addConnection($databaseConf);
    $events = new Dispatcher(new Illuminate\Container\Container());
    /*$events->listen('Illuminate\Database\Events\QueryExecuted', function ($query) use ($container) {
        $logger = $container->get('logger');
        $logger->info(sprintf("[mysql_query] %s executed in %f seconds", $query->sql, $query->time),
            ['pdo_bindings' => $query->bindings]);
    });*/
    $capsule->setEventDispatcher($events);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
}

// Loading application routes
require ROOT_DIR . DIRECTORY_SEPARATOR . 'app/routes.php';
