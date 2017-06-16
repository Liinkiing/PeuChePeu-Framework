<?php

namespace App\Blog;

use App\Auth\AuthModule;
use App\Blog\Controller\BlogController;
use Core\App;
use Core\Module;
use Core\View\ViewInterface;
use DI\Container;

class BlogModule extends Module
{
    public $migrations = __DIR__ . '/db/migrations';
    public $seeds = __DIR__ . '/db/seeds';

    public function __construct(Container $container, ViewInterface $view)
    {
        $container->call([$this, 'routes']);
        $view->addPath(__DIR__ . '/views', 'blog');
    }

    public function routes(App $app, AuthModule $authModule)
    {
        $app->get('/blog', [BlogController::class, 'index'])->setName('blog.index');
        $app->get('/blog/{slug}', [BlogController::class, 'show'])->setName('blog.show');

        $app->group($app->getContainer()->get('backend.prefix'), function () {
            $this->get('/blog', [BlogController::class, 'index'])->setName('backend.blog.index');
        })->add($authModule->makeRoleMiddleware('admin'));
    }
}
