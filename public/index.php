<?php
require dirname(__DIR__) . '/vendor/autoload.php';

// On démarre slim
$app = new \Core\App(dirname(__DIR__) . '/config.php');
$container = $app->getContainer();
$container->set(\Core\App::class, $app);

// Middlewares
$app->add(new \Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware());

// Les modules
$container->get(\Core\ModulesContainer::class)
    ->add($container->get(\App\Base\BaseModule::class))
    ->add($container->get(\App\Auth\AuthModule::class))
    ->add($container->get(\App\Blog\BlogModule::class));

// On lance l'application
if (php_sapi_name() !== "cli") {
    $app->run();
}