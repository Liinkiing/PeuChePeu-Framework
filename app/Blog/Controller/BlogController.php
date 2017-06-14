<?php

namespace App\Blog\Controller;

use App\Blog\Repository\PostRepository;
use Core\Controller;
use Core\View\ViewInterface;
use Slim\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request, ViewInterface $view, PostRepository $postRepository)
    {
        $page = $request->getParam('page', 1);
        $posts = $postRepository->getPaginatedPosts(12, $page);

        return $view->render('@blog/index', compact('posts', 'page'));
    }

    public function show(string $slug, PostRepository $postRepository, ViewInterface $view)
    {
        $post = $postRepository->findBySlug($slug);

        return $view->render('@blog/show', compact('post'));
    }
}
