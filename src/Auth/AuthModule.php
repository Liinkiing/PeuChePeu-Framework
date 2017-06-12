<?php

namespace App\Auth;

use App\Auth\Controller\SessionController;
use Core\SlimApp;
use Core\View\ViewInterface;

class AuthModule
{
    public $migrations = __DIR__ . '/db/migrations';
    public $seeds = __DIR__ . '/db/seeds';

    public function __construct(SlimApp $app)
    {
        $app->getContainer()->get(ViewInterface::class)->addPath(__DIR__ . '/views', 'auth');
        $this->routes($app);
    }

    public function routes(SlimApp $router)
    {
        $router->get('/login', [SessionController::class, 'create'])->setName('auth.login');
        $router->post('/login', [SessionController::class, 'store']);
    }
}
