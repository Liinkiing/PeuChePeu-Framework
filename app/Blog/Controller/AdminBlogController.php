<?php

namespace App\Blog\Controller;

use App\Blog\PostTable;
use App\Blog\PostUpload;
use App\Blog\Validator\PostValidator;
use Core\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use Slim\Http\Request;

class AdminBlogController extends Controller
{
    public function index(PostTable $postTable, Request $request): string
    {
        $page = $request->getParam('page', 1);
        $posts = $postTable->findPaginated(10, $page);

        return $this->render('@blog/admin/index', compact('posts'));
    }

    public function create(PostTable $postTable, ServerRequestInterface $request, PostUpload $uploader)
    {
        $post = [
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($request->getMethod() === 'POST') {
            /* @var $files UploadedFileInterface[] */
            $files = $request->getUploadedFiles();
            $params = array_merge($request->getParsedBody(), $files);
            $errors = PostValidator::validates($params, true);
            if (empty($errors)) {
                // On sauvegarde les changements
                $post = $this->postParams($params);

                // Upload du fichier
                $post['image'] = $uploader->upload($files['image']);

                // On persiste l'article
                $postTable->create($post);

                // Message de succès
                $this->flash('success', "L'article a bien été créé");

                return $this->redirect('blog.admin.index');
            }
            $post = $this->postParams($params);
        }

        return $this->render('@blog/admin/create', compact('errors', 'post'));
    }

    public function edit(int $id, PostTable $postTable, ServerRequestInterface $request, PostUpload $uploader)
    {
        $post = $postTable->find($id);

        if ($request->getMethod() === 'POST') {
            /* @var $files UploadedFileInterface[] */
            $files = $request->getUploadedFiles();
            $params = array_merge($request->getParsedBody(), $files);
            $errors = PostValidator::validates($params);
            if (empty($errors)) {
                // On sauvegarde les changements
                $postParams = $this->postParams($params);

                // Upload du fichier
                if (isset($files['image'])) {
                    $image = $uploader->upload($files['image'], $post->image);
                    $postParams['image'] = $image;
                }

                // On met à jour l'article
                $postTable->update($post->id, $postParams);

                $this->flash('success', "L'article a bien été modifié");

                return $this->redirect('blog.admin.index');
            }
        }

        return $this->render('@blog/admin/edit', compact('post', 'errors'));
    }

    public function destroy(int $id, PostTable $postTable, PostUpload $uploader): ResponseInterface
    {
        $post = $postTable->find($id);
        $uploader->delete($post->image);
        $postTable->delete($id);
        $this->flash('success', "L'article a bien été supprimé");

        return $this->redirect('blog.admin.index');
    }

    private function postParams(array $params): array
    {
        return array_filter($params, function ($key) {
            return in_array($key, ['name', 'content', 'created_at'], true);
        }, ARRAY_FILTER_USE_KEY);
    }
}
