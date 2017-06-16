<?php

return [
    // Chemins
    'basepath'       => dirname(__DIR__),
    'backend.prefix' => '/admin',
    'backend.role'   => 'admin',

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

    // Modules
    \Core\ModulesContainer::class => \DI\object(),

    // Vue
    \Slim\Views\TwigExtension::class      => \DI\object()->constructor(\DI\get('router'), \DI\get('request')),
    \Core\View\ViewInterface::class       => \DI\object(\Core\View\TwigView::class),

    // Session
    'session'                             => \Di\get(\Core\Session\SessionInterface::class),
    \Core\Session\SessionInterface::class => \DI\object(\Core\Session\Session::class),
    \Slim\Flash\Messages::class           => \DI\object(\Slim\Flash\Messages::class)->constructor(\DI\get('session')),
    \Slim\Csrf\Guard::class               => \DI\object()
                                                ->constructor(
                                                    'csrf',
                                                    \DI\get(\Core\Session\SessionInterface::class),
                                                    200,
                                                    10,
                                                    true
                                                ),

    // Database
    'db_name'                             => \DI\env('db_name'),
    'db_username'                         => \DI\env('db_username', 'root'),
    'db_password'                         => \DI\env('db_password', 'root'),
    'db_host'                             => \DI\env('db_host', '127.0.0.1'),
    \Core\Database\Database::class        => \DI\object()->constructor(
                                                \DI\get('db_name'),
                                                \DI\get('db_username'),
                                                \DI\get('db_password'),
                                                \DI\get('db_host')
                                            ),
    'db'                                  => \DI\get(\Core\Database\Database::class),
];
