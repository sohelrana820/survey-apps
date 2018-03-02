<?php
return [
    'app' => [
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        // Renderer settings
        'renderer' => [
            'template_path' => ROOT_DIR . DIRECTORY_SEPARATOR . 'templates/',
        ],
        // View settings
        'view' => [
            'template_path' => ROOT_DIR . DIRECTORY_SEPARATOR . 'templates/',
            'twig' => [
                'cache' => ROOT_DIR . DIRECTORY_SEPARATOR . "tmp/cache/twig",
                'debug' => true,
                'auto_reload' => true,
            ],
        ],
        // Monolog settings
        'logger' => [
            'name' => 'logger_name',
            'path' => ROOT_DIR . DIRECTORY_SEPARATOR . 'logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
            'monolog_handlers' => ['php://stdout', 'file']
        ],
        "database_require" => false,
        'databases' => [
            'driver' => 'mysql',
            'host' => 'DATABASE_HOST',
            'database' => 'DATABASE_NAME',
            'username' => 'DATABASE_USER',
            'password' => 'DATABASE_PASSWORD',
            'unix_socket' => '',
            'charset' => 'Utf8',
            'collation' => 'utf8_general_ci',
            'prefix' => ''
        ],
        'memcache' => [
            'active' => true,
            'hosts' => [
                ['localhost', 11211, 33]
            ]
        ],
    ]
];