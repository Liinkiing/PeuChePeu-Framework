<?php

namespace App\Auth;

use App\Auth\Controller\SessionController;
use Core\App;
use Core\View\TwigView;
use Core\View\ViewInterface;

class AuthModule
{
    public $migrations = __DIR__ . '/db/migrations';
    public $seeds = __DIR__ . '/db/seeds';

    public function __construct(App $app)
    {
        $view = $app->getContainer()->get(ViewInterface::class);
        $view->addPath(__DIR__ . '/views', 'auth');

        if ($view instanceof TwigView) {
            $view->getTwig()->addExtension($app->getContainer()->get(Twig\AuthTwigExtension::class));
        }

        $this->routes($app);
    }

    public function routes(App $router)
    {
        $router->get('/login', [SessionController::class, 'create'])->setName('auth.login');
        $router->post('/login', [SessionController::class, 'store']);
    }
}
