<?php

namespace App\Admin;

use Core\Module;
use Core\View\ViewInterface;

class AdminModule extends Module
{
    public function __construct(ViewInterface $view)
    {
        $view->addPath(__DIR__ . '/views', 'admin');
    }
}
