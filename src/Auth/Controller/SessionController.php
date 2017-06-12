<?php

namespace App\Auth\Controller;

use Core\View\ViewInterface;
use Slim\Http\Request;

class SessionController
{
    public function create(ViewInterface $view)
    {
        return $view->render('@auth/login');
    }

    public function store(Request $request)
    {
        r('validation');
        // TODO : Valider les données
    }
}
