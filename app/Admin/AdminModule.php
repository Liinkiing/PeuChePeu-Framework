<?php

namespace App\Admin;

use Core\App;
use Core\Module;
use Core\View\ViewInterface;

class AdminModule extends Module
{
    public const DEFINITIONS = __DIR__ . '/config.php';

    public function __construct(App $app)
    {
        $app->getContainer()->get(ViewInterface::class)->addPath(__DIR__ . '/views', 'admin');
        $app->group($app->getContainer()->get('admin.prefix'), function () {
            $this->get('', [AdminController::class, 'index'])->setName('admin.index');
        })->add($app->getContainer()->get('admin.middleware'));
    }
}
