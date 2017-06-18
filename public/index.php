<?php
require dirname(__DIR__) . '/vendor/autoload.php';

// On démarre slim
$app = new \Core\App(dirname(__DIR__) . '/config.php');
$container = $app->getContainer();

// Les modules
$container->set('modules.base', $container->get(\App\Base\BaseModule::class));
$container->set('modules.admin', $container->get(\App\Admin\AdminModule::class));
$container->set('modules.auth', $container->get(\App\Auth\AuthModule::class));
$container->set('modules.blog', $container->get(\App\Blog\BlogModule::class));

// On lance l'application
if (php_sapi_name() !== "cli") {
    $app->run();
}