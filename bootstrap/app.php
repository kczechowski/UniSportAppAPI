<?php

define('ROOT_PATH', __DIR__ . '/../');
define('VENDOR_PATH', __DIR__ . '/../vendor/');
define('APP_PATH', __DIR__ . '/../app/');
define('PUBLIC_PATH', __DIR__ . '/../public/');

require VENDOR_PATH . 'autoload.php';

$dotenv = \Dotenv\Dotenv::create(ROOT_PATH);
$dotenv->load();

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
        'db' => [
            'driver' => $_ENV['DB_DRIVER'],
            'host' => $_ENV['DB_HOST'],
            'database' => $_ENV['DB_DBNAME'],
            'username' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
            'charset' => $_ENV['DB_CHARSET'],
            'collation' => $_ENV['DB_COLLATION'],
            'prefix' => $_ENV['DB_PREFIX'],
        ]
    ],
]);

$app->add(new Tuupola\Middleware\CorsMiddleware([
    "origin" => ["*"],
    "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
    "headers.allow" => ["Content-Type"],
    "headers.expose" => [],
    "credentials" => false,
    "cache" => 0,
]));

$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);

$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule){
    return $capsule;
};

$authMiddleware = new \App\Utils\OAuth2Middleware();


require APP_PATH . 'routes.php';