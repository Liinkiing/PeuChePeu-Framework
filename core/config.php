<?php

return [
    // Chemins
    'basepath' => dirname(__DIR__),

    // Paramètres Slim
    'settings' => [
        'httpVersion'                       => '1.1',
        'responseChunkSize'                 => 4096,
        'outputBuffering'                   => 'append',
        'determineRouteBeforeAppMiddleware' => false,
        'displayErrorDetails'               => true,
        'addContentLengthHeader'            => true,
        'routerCacheFile'                   => false,
        'whoops.editor'                     => 'sublime',
        'debug'                             => true
    ],

    // Vue
    \Slim\Views\TwigExtension::class      => \DI\object()->constructor(\DI\get('router'), \DI\get('request')),
    \Core\View\ViewInterface::class       => \DI\object(\Core\View\TwigView::class),

    // Session
    'session'                             => \Di\get(\Core\Session\SessionInterface::class),
    \Core\Session\SessionInterface::class => \DI\object(\Core\Session\Session::class),
    \Slim\Flash\Messages::class           => \DI\object(\Slim\Flash\Messages::class)->constructor(\DI\get('session')),

    // Database
    'db_name'                             => \DI\env('db_name'),
    'db_username'                         => \DI\env('db_username', 'root'),
    'db_password'                         => \DI\env('db_password', 'root'),
    'db_host'                             => \DI\env('db_host', 'localhost'),
    \Core\Database\Database::class        => \DI\object()->constructor(
                                                \DI\get('db_name'),
                                                \DI\get('db_username'),
                                                \DI\get('db_password'),
                                                \DI\get('db_host')
                                            ),
];
