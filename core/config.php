<?php

use Schnittstabil\Psr7\Csrf\MiddlewareBuilder as CsrfMiddlewareBuilder;

return [
    // Chemins
    'basepath'                            => dirname(__DIR__),
    'settings.displayErrorDetails'        => true,
    'settings.routerCacheFile'            => false,
    'errorHandler'                        => \DI\object(\Core\Handler::class),

    // Misc
    \Slim\Interfaces\RouterInterface::class => \DI\object(\Slim\Router::class),

    // Vue
    \Slim\Views\TwigExtension::class      => \DI\object()->constructor(\DI\get('router'),
        \DI\get('request')),
    \Core\View\ViewInterface::class       => \DI\object(\Core\View\TwigView::class),

    // Session
    'session'                             => \Di\get(\Core\Session\SessionInterface::class),
    \Core\Session\SessionInterface::class => \DI\object(\Core\Session\Session::class),
    \Slim\Flash\Messages::class           => \DI\object(\Slim\Flash\Messages::class)->constructor(\DI\get('session')),

    // CSRF
    'csrf.name'                           => 'X-XSRF-TOKEN',
    'csrf.key'                            => \DI\env('csrf_key', 'fake key'),
    'csrf'                                => function ($c) {
        return CsrfMiddlewareBuilder::create($c->get('csrf.key'))
            ->buildSynchronizerTokenPatternMiddleware($c->get('csrf.name'));
    },
    \Core\Twig\CsrfExtension::class       => \DI\object()
        ->constructor(
            \DI\get('csrf.name'),
            \DI\get('csrf')
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

    // Fichiers
    'upload_path' => \DI\string('{basepath}/public/uploads'),
];
