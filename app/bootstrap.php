<?php

use App\helpers\Utility;
use Illuminate\Events\Dispatcher;
use Monolog\Handler\StreamHandler;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

// Getting application container;
$container = $app->getContainer();
$settings = $container->get('settings');

$app->add(function (Request $request, Response $response, $next){
    /*$response = $response->withHeader('X-XSS-Protection', '1; mode=block');
    $response = $response->withHeader('X-Frame-Options', 'SAMEORIGIN');
    $response = $response->withHeader('X-Content-Type-Options', 'nosniff');
    $response = $response->withHeader('Referrer-Policy', 'origin');
    $response = $response->withAddedHeader('Cache-Control', 'max-age=86400, public');
    $response = $response->withHeader('Strict-Transport-Security', 'max-age=2592000');
    $response = $response->withHeader('Content-Security-Policy', "default-src 'self' data: *.google-analytics.com *.google.com *.googleapis.com *.gstatic.com *.paypalobjects.com *.paypal.com *.googletagmanager.com 'unsafe-inline'");*/
    return $next($request, $response);
});

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
    $view->addExtension(new \App\components\TwigExtra());
    $twigExtra = $view->getEnvironment();
    $twigExtra->addGlobal('session', $_SESSION);
    $twigExtra->addGlobal('config', $settings);
    $twigExtra->addGlobal('queryParams', $_GET);

    // Creating rating filter.
    $twigFilter = new Twig_SimpleFilter(
        'rating_percentage',
        function ($rating, $totalRating = 5) {
            $percentage = ($rating * 100) / $totalRating;
            return $percentage;
        }
    );

    $truncateFilter = (new Twig_SimpleFilter(
        'truncate',
        function ($string, $length) {
            if (strlen($string) < $length) {
                return $string;
            } else {
                return array_shift(str_split($string, $length)) . "...";
            }
        }
    ));

    $slugToStr = (new Twig_SimpleFilter(
        'slug_to_str',
        function ($string) {
            return ucwords(str_replace('-', ' ', $string));
        }
    ));

    $scoreAnalysis = (new Twig_SimpleFilter(
        'score_analysis',
        function ($singleScore, $type) {
            $ratedBy = $singleScore['rated_by'];
            return number_format($singleScore[$type] / $ratedBy, 2);
        }
    ));

    $buildSortingLinkFilter = (new Twig_SimpleFilter(
        'build_sorting_link',
        function ($pagination, $order = null, $sort = null) {
            if ($order) {
                $pagination['paginationSuffixRaw']['order'] = $order;
            } else {
                unset($pagination['paginationSuffixRaw']['order']);
            }

            if ($sort) {
                $pagination['paginationSuffixRaw']['sort'] = $sort;
            } else {
                unset($pagination['paginationSuffixRaw']['sort']);
            }

            if (array_key_exists('featured', $pagination['paginationSuffixRaw'])) {
                unset($pagination['paginationSuffixRaw']['featured']);
            }

            if (array_key_exists('popular', $pagination['paginationSuffixRaw'])) {
                unset($pagination['paginationSuffixRaw']['popular']);
            }

            $link = sprintf('%s?%s', $pagination['pageName'], http_build_query($pagination['paginationSuffixRaw']));
            return $link;
        }
    ));

    $selectSortingFilter = (new Twig_SimpleFilter(
        'select_sorting',
        function ($pagination, $selectValue) {
            $selected = '';
            $query = $pagination['paginationSuffixRaw'];
            if (array_key_exists('title', $query)) {
                unset($query['title']);
            }
            if (array_key_exists('recent', $query)) {
                unset($query['recent']);
            }

            if (sizeof($query) == 0 && $selectValue == 'newest') {
                $selected = 'selected="selected"';
            } elseif (sizeof($query) == 1 && isset($query['sort']) && $query['sort'] == 'desc' && $selectValue == 'newest') {
                $selected = 'selected="selected"';
            } elseif (sizeof($query) == 1 && isset($query['sort']) && $query['sort'] == 'asc' && $selectValue == 'oldest') {
                $selected = 'selected="selected"';
            } elseif (sizeof($query) == 2 && $query['order'] == 'sales' && isset($query['sort']) &&  $query['sort'] == 'desc' && $selectValue == 'most-sold') {
                $selected = 'selected="selected"';
            } elseif (array_key_exists('featured', $query) && $selectValue == 'featured') {
                $selected = 'selected="selected"';
            } elseif (array_key_exists('popular', $query) && $selectValue == 'popular') {
                $selected = 'selected="selected"';
            } elseif (sizeof($query) == 2 && $query['order'] == 'price'  && isset($query['sort']) &&  $query['sort'] == 'desc' && $selectValue == 'price_h_l') {
                $selected = 'selected="selected"';
            } elseif (sizeof($query) == 2 && $query['order'] == 'price'  && isset($query['sort']) && $query['sort'] == 'asc' && $selectValue == 'price_l_h') {
                $selected = 'selected="selected"';
            }
            return $selected;
        }
    ));

    $view->getEnvironment()->addFilter($twigFilter);
    $view->getEnvironment()->addFilter($truncateFilter);
    $view->getEnvironment()->addFilter($buildSortingLinkFilter);
    $view->getEnvironment()->addFilter($selectSortingFilter);
    $view->getEnvironment()->addFilter($slugToStr);
    $view->getEnvironment()->addFilter($scoreAnalysis);
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


    if (Utility::isAppEngine()) {
        $logger->pushHandler(new \Monolog\Handler\SyslogHandler($container['config']['logger']['name']));
    } else {
        $logger->pushHandler(new StreamHandler($config['logger']['path'], $config['logger']['level']));
    }
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

        if (!$memcache) {
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
        return $container['view']->render($response->withStatus(404), 'error/404.twig');
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
        return $container['view']->render($response->withStatus(500), 'error/500.twig');
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
    if (Utility::isAppEngine()) {
        $databaseConf['host'] = null;
    } else {
        $databaseConf['unix_socket'] = null;
    }

    $capsule = new Illuminate\Database\Capsule\Manager();
    $capsule->addConnection($databaseConf);
    $events = new Dispatcher(new Illuminate\Container\Container());
    $events->listen('Illuminate\Database\Events\QueryExecuted', function ($query) use ($container) {
        $logger = $container->get('logger');
        $logger->info(
            sprintf("[mysql_query] %s executed in %f seconds", $query->sql, $query->time),
            ['pdo_bindings' => $query->bindings]
        );
    });
    $capsule->setEventDispatcher($events);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
}

// Loading application routes
require ROOT_DIR . DIRECTORY_SEPARATOR . 'app/routes.php';
