<?php

namespace App\Base;

use App\Base\Controller\HomeController;
use Core\App;
use Core\View\ViewInterface;

class BaseModule
{
    public function __construct(App $app)
    {
        $app->getContainer()->get(ViewInterface::class)->addPath(__DIR__ . '/views');
        $app->get('/', [HomeController::class, 'index'])->setName('root');
    }
}
