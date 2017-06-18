<?php

namespace App\Blog\Controller;

use App\Blog\Table\PostTable;
use App\Blog\Validator\PostValidator;
use Core\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Request;

class AdminBlogController extends Controller
{
    public function index(PostTable $postTable, Request $request): string
    {
        $page = $request->getParam('page', 1);
        $posts = $postTable->findPaginated(10, $page);

        return $this->render('@blog/admin/index', compact('posts'));
    }

    public function create(PostTable $postTable, ServerRequestInterface $request)
    {
        $post = [
            'created_at' => date('Y-m-d H:i:s')
        ];
        if ($request->getMethod() === 'POST') {
            [$validates, $post] = $this->validateRequest($request);
            if ($validates) {
                $postTable->create($post);
                $this->flash('success', "L'article a bien été créé");

                return $this->redirect('blog.admin.index');
            }
            $errors = $post;
        }

        return $this->render('@blog/admin/create', compact('errors', 'post'));
    }

    public function edit(int $id, PostTable $postTable, ServerRequestInterface $request)
    {
        $post = $postTable->find($id);

        if ($request->getMethod() === 'POST') {
            $post = $request->getParsedBody();
            [$validates, $data] = $this->validateRequest($request);
            if ($validates) {
                $postTable->update($id, $data);
                $this->flash('success', "L'article a bien été modifié");

                return $this->redirect('blog.admin.index');
            }
            $errors = $data;
        }

        return $this->render('@blog/admin/edit', compact('post', 'errors'));
    }

    public function destroy(int $id, PostTable $postTable): ResponseInterface
    {
        $postTable->delete($id);
        $this->flash('success', "L'article a bien été supprimé");

        return $this->redirect('blog.admin.index');
    }

    private function validateRequest(ServerRequestInterface $request): array
    {
        $validator = new PostValidator($request->getParsedBody());
        if ($validator->validates()) {
            $data = array_filter($request->getParsedBody(), function ($key) {
                return in_array($key, ['name', 'content', 'created_at'], true);
            }, ARRAY_FILTER_USE_KEY);

            return [true, $data];
        }

        return [false, $validator->errors];
    }
}
