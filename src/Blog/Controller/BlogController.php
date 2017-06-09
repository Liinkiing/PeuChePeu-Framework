<?php

namespace App\Blog\Controller;

use App\Blog\Repository\PostRepository;
use Core\Controller;
use Core\View;

class BlogController extends Controller
{
    public function index(View $view, PostRepository $postRepository)
    {
        $posts = $postRepository->getPosts();

        return $view->render('@blog/index.html.twig', compact('posts'));
    }
}
