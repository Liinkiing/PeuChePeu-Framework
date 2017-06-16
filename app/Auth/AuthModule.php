<?php

namespace App\Auth;

use App\Auth\Controller\SessionController;
use App\Auth\Middleware\RoleMiddleware;
use Core\App;
use Core\Module;
use Core\View\TwigView;
use Core\View\ViewInterface;
use DI\Container;

class AuthModule extends Module
{
    public $migrations = __DIR__ . '/db/migrations';
    public $seeds = __DIR__ . '/db/seeds';

    /**
     * @var Container
     */
    private $container;

    public function __construct(Container $container)
    {
        $container->call([$this, 'routes']);
        $container->call([$this, 'view']);
        $this->container = $container;
    }

    public function view(ViewInterface $view, Twig\AuthTwigExtension $extension)
    {
        $view->addPath(__DIR__ . '/views', 'auth');
        if ($view instanceof TwigView) {
            $view->getTwig()->addExtension($extension);
        }
    }

    public function routes(App $router)
    {
        $router->get('/login', [SessionController::class, 'create'])->setName('auth.login');
        $router->post('/login', [SessionController::class, 'store']);
        $router->delete('/logout', [SessionController::class, 'destroy'])->setName('auth.logout');
    }

    public function makeRoleMiddleware(string $role): RoleMiddleware
    {
        return new RoleMiddleware($this->container->get(AuthService::class), $role);
    }
}
