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
        'attachment_path' => ROOT_DIR . DIRECTORY_SEPARATOR . 'public/attachments',
        'download_path' => ROOT_DIR . DIRECTORY_SEPARATOR . 'templates/download_items',
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
        "enable_memcache" => false,
        'memcache' => [
            'active' => true,
            'hosts' => [
                ['localhost', 11211, 33]
            ]
        ],
        'mailgun' => [
            'api_key' => 'key-8cef2210bed7c5c71ce94a1f5480b4f9',
            'domain' => 'sohelrana.me'
        ],
        'email' => [
            'from_name' => 'Theme Vessel',
            'from_email' => 'no-reply@sohelrana.me',
            'support_name' => 'Theme Vessel Support',
            'support_email' => 'themevessel.us@gmail.com',
        ]
    ]
];