<?php

define('ROOT_PATH', __DIR__ . '/../');
define('VENDOR_PATH', __DIR__ . '/../vendor/');
define('APP_PATH', __DIR__ . '/../app/');
define('PUBLIC_PATH', __DIR__ . '/../public/');

require VENDOR_PATH . 'autoload.php';

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
        'db' => [
            'driver' => 'mysql',
            'host' => '10.10.10.10',
            'database' => 'dev_db',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]
    ],
]);

$app->add(new \Tuupola\Middleware\CorsMiddleware);

$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);

$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule){
    return $capsule;
};


require APP_PATH . 'routes.php';