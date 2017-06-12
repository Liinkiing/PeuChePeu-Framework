<?php
return [
    'basepath'                            => dirname(__DIR__),
    'settings'                            => [
        "httpVersion"                       => "1.1",
        "responseChunkSize"                 => 4096,
        "outputBuffering"                   => "append",
        "determineRouteBeforeAppMiddleware" => false,
        "displayErrorDetails"               => true,
        "addContentLengthHeader"            => true,
        "routerCacheFile"                   => false,
        "whoops.editor"                     => 'sublime',
        "debug"                             => true
    ],
    \Slim\Views\TwigExtension::class      => \DI\object()->constructor(\DI\get('router'), \DI\get('request')),
    \Core\View\ViewInterface::class       => \DI\object(\Core\View\SlimView::class),
    \Core\Session\SessionInterface::class => \DI\object(\Core\Session\Session::class),
    'db'                                  => \DI\object(\Core\Database\DB::class)->constructor('monframework'),
    PDO::class                            => function (\Psr\Container\ContainerInterface $container) {
        return $container->get('db')->getPdo();
    }
];
