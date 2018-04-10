<?php
return [
    'app' => [
        'site_url' => 'http://localhost:8081',
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
        'tmp_path' => ROOT_DIR . DIRECTORY_SEPARATOR . "tmp",
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
            'host' => '35.188.118.82',
            'database' => 'themevessel_shop',
            'username' => 'sohel',
            'password' => 'Preview@Dev!@#',
            'unix_socket' => '/cloudsql/themevessel-200614:us-central1:themevessel;dbname=themevessel_shop',
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
            'domain' => 'mg.themevessel.com'
        ],
        'email' => [
            'from_name' => 'ThemeVessel',
            'from_email' => 'no-reply@sohelrana.me',
            'support_name' => 'ThemeVessel Support',
            'support_email' => 'support@themevessel.com',
        ],
        'google-re-captcha' => [
            'site-key' => '6LegCjoUAAAAAJL_Jz-r4rDa_CTyH12aQ0dlzDVp',
            'site-secret' => '6LegCjoUAAAAABfjPBTa6-Jqhay5Bi69hnkWMS3s'
        ],
        'paypal' => [
            'mode' => 'sandbox', // sandbox | production
            'sandbox_key' => 'AZDxjDScFpQtjWTOUtWKbyN_bDt4OgqaF4eYXlewfBP4-8aqX3PiV8e1GWU6liB2CUXlkA59kJXE7M6R',
            'production_key' => '',
        ]
    ]
];