<?php

namespace App\Base;

use Core\SlimApp;
use Core\View;

class BaseModule
{
    public function __construct(SlimApp $app)
    {
        $app->getContainer()->get(View::class)->addPath(__DIR__.'/views');
    }
}
