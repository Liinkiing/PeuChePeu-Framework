<?php

namespace App\Blog\Controller;

use Core\Controller;

class BlogController extends Controller
{
    public function index()
    {
        return $this->render('@blog/index.html.twig', ['posts' => 'Hello']);
    }
}
