<?php

namespace App\Base\Controller;

use Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return $this->render('home');
    }
}
