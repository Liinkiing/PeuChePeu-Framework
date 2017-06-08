<?php
require '../vendor/autoload.php';

// Config
$config = [
    'settings' => [
        'debug'         => true,
        'whoops.editor' => 'sublime',
        'displayErrorDetails' => true,
    ]
];

// On démarre slim
$app = new \App\App($config);

// Middlewares
$app->add(new \Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware($app));

// Notre application
new \App\Blog\Loader($app);

$app->run();