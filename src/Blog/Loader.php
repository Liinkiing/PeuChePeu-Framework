<?php

namespace App\Blog;

use App\Blog\Controller\BlogController;
use Core\View;

class Loader
{
    public function __construct(\Slim\App $app)
    {
        $this->routes($app);
        $app->getContainer()->get(View::class)->registerNamespace('blog', __DIR__.'/views');
    }

    public function routes($app)
    {
        $app->get('/blog', [BlogController::class, 'index']);
    }
}
