<?php
// Session started
session_start();

// Define ROOT directory
define('ROOT_DIR', dirname(__DIR__));

// Loading vendor autoload.php file
require ROOT_DIR . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

// Getting application configuration data
$config = new \Noodlehaus\Config(ROOT_DIR . DIRECTORY_SEPARATOR . 'config.php');


// Initialize slim application
$app = new \Slim\App(['settings' => $config->get('app')]);

// Loading application bootstrap file
require ROOT_DIR . DIRECTORY_SEPARATOR . 'app/bootstrap.php';

// Run slim application
$app->run();