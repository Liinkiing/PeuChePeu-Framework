<?php

namespace App\Blog;

use App\Auth\AuthModule;
use App\Blog\Controller\AdminBlogController;
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
        $app->group($app->getContainer()->get('admin.prefix'), function () {
            $this->get('/blog', [AdminBlogController::class, 'index'])->setName('blog.admin.index');
            $this->map(['GET', 'POST'], '/blog/{id:[0-9]+}', [AdminBlogController::class, 'edit'])->setName('blog.admin.edit');
            $this->map(['GET', 'POST'], '/blog/new', [AdminBlogController::class, 'create'])->setName('blog.admin.create');
            $this->delete('/blog/{id:[0-9]+}', [AdminBlogController::class, 'destroy'])->setName('blog.admin.destroy');
        })->add($authModule->makeRoleMiddleware('admin'));
    }
}
