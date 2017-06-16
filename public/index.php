<?php
require dirname(__DIR__) . '/vendor/autoload.php';

// On démarre slim
$app = new \Core\App(dirname(__DIR__) . '/config.php');
$container = $app->getContainer();

// Middlewares
$app->add(new \Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware());
$app->add($container->get(\Slim\Csrf\Guard::class));

// Les modules
$container->set('modules.base', $container->get(\App\Base\BaseModule::class));
$container->set('modules.auth', $container->get(\App\Auth\AuthModule::class));
$container->set('modules.blog', $container->get(\App\Blog\BlogModule::class));

// On lance l'application
if (php_sapi_name() !== "cli") {
    $app->run();
}