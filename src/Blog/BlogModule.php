<?php

namespace App\Blog;

use App\Blog\Controller\BlogController;
use Core\View;

class BlogModule
{
    public $migrations = __DIR__.'/db/migrations';
    public $seeds = __DIR__.'/db/seeds';

    public function __construct(\Slim\App $app)
    {
        $this->routes($app);
        $app->getContainer()->get(View::class)->addPath(__DIR__.'/views', 'blog');
    }

    public function routes($app)
    {
        $app->get('/blog', [BlogController::class, 'index'])->setName('blog.index');
    }
}