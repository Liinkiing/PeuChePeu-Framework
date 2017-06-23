<?php

namespace App\Blog\Controller;

use App\Blog\PostTable;
use App\Blog\PostUpload;
use App\Blog\Request\BlogRequest;
use Core\Controller;
use Psr\Http\Message\ResponseInterface;
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

    public function create()
    {
        $post = [
            'created_at' => date('Y-m-d H:i:s')
        ];

        return $this->render('@blog/admin/create', ['post' => $post]);
    }

    public function store(BlogRequest $blogRequest, PostTable $postTable, PostUpload $uploader)
    {
        $post = $blogRequest->getParams();

        if ($blogRequest->validates()) {
            /* @var $files UploadedFileInterface[] */
            $files = $blogRequest->getRequest()->getUploadedFiles();

            // Upload du fichier
            $post['image'] = $uploader->upload($files['image']);

            // On persiste l'article
            $postTable->create($post);

            // Message de succès
            $this->flash('success', "L'article a bien été créé");

            return $this->redirect('blog.admin.index');
        }

        return $this->render('@blog/admin/create', array_merge(['post' => $post], $blogRequest->getAttributes()));
    }

    public function edit(int $id, PostTable $postTable): string
    {
        $post = $postTable->findOrFail($id);

        return $this->render('@blog/admin/edit', compact('post'));
    }

    public function update(int $id, PostTable $postTable, BlogRequest $blogRequest, PostUpload $uploader)
    {
        $post = $postTable->findOrFail($id);
        $postParams = $blogRequest->getParams();
        if ($blogRequest->validates()) {
            /* @var UploadedFileInterface $file */
            $file = $blogRequest->getRequest()->getUploadedFiles()['image'];

            if ($file && $file->getError() === UPLOAD_ERR_OK) {
                $image = $uploader->upload($file, $post->image);
                $postParams['image'] = $image;
            }

            // On met à jour la table
            $postTable->update($id, $postParams);
            $this->flash('success', "L'article a bien été modifié");

            return $this->redirect('blog.admin.index');
        }
        $postParams = $blogRequest->getParams();

        return $this->render('@blog/admin/edit', [
            'post'   => $postParams,
            'errors' => $blogRequest->getErrors()
        ]);
    }

    public function destroy(int $id, PostTable $postTable, PostUpload $uploader): ResponseInterface
    {
        $post = $postTable->findOrFail($id);
        $uploader->delete($post->image);
        $postTable->delete($id);
        $this->flash('success', "L'article a bien été supprimé");

        return $this->redirect('blog.admin.index');
    }
}
