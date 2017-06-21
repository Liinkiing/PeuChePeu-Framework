<?php

namespace App\Blog\Controller;

use App\Blog\PostTable;
use Core\Controller;
use Core\View\ViewInterface;
use Slim\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request, ViewInterface $view, PostTable $postTable)
    {
        $page = $request->getParam('page', 1);
        $posts = $postTable->findPaginated(12, $page);

        return $view->render('@blog/index', compact('posts', 'page'));
    }

    public function show(string $slug, PostTable $postTable, ViewInterface $view)
    {
        $post = $postTable->findBySlug($slug);

        return $view->render('@blog/show', compact('post'));
    }
}
