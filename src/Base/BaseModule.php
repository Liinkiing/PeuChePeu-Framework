<?php

namespace App\Base;

use Core\SlimApp;
use Core\View\ViewInterface;

class BaseModule
{
    public function __construct(SlimApp $app)
    {
        $app->getContainer()->get(ViewInterface::class)->addPath(__DIR__ . '/views');
    }
}
