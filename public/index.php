<?php
require dirname(__DIR__) . '/vendor/autoload.php';

// On démarre slim
$app = new \Core\App(
    dirname(__DIR__) . '/config.php',
    [
        \App\Base\BaseModule::class,
        \App\Admin\AdminModule::class,
        \App\Auth\AuthModule::class,
        \App\Blog\BlogModule::class
    ]
);

// On lance l'application
if (php_sapi_name() !== "cli") {
    $app->run();
}