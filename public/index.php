<?php
require dirname(__DIR__) . '/vendor/autoload.php';

// Config
$config = [
    'settings' => [
        'debug'               => true,
        'whoops.editor'       => 'sublime',
        'displayErrorDetails' => true,
    ]
];

// On démarre slim
$app = new \Core\App(dirname(__DIR__) . '/config.php');

// Middlewares
$app->add(new \Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware());

// Les modules
$app->addModule(\App\Base\BaseModule::class);
$app->addModule(\App\Blog\BlogModule::class);
$app->addModule(\App\Auth\AuthModule::class);

// On lance l'application
if (php_sapi_name() !== "cli") {
    $app->run();
}