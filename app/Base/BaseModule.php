<?php

namespace App\Base;

use App\Base\Controller\HomeController;
use Core\App;
use Core\Module;
use Core\View\ViewInterface;

class BaseModule extends Module
{
    public function __construct(App $app, ViewInterface $view)
    {
        $view->addPath(__DIR__ . '/views');
        $app->get('/', [HomeController::class, 'index'])->setName('root');
    }
}
