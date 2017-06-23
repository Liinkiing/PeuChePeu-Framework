<?php

namespace App\Blog\Request;

use App\Blog\PostTable;
use Core\Validator;
use Psr\Http\Message\ServerRequestInterface;

class BlogRequest
{
    /**
     * @var array
     */
    private $errors;

    /**
     * @var PostTable
     */
    private $postTable;

    /**
     * @var ServerRequestInterface
     */
    private $request;

    public function __construct(ServerRequestInterface $request, PostTable $postTable)
    {
        $this->request = $request;
        $this->postTable = $postTable;
    }

    /**
     * Valide les données.
     */
    public function validates(): bool
    {
        $params = array_merge($this->request->getParsedBody(), $this->request->getUploadedFiles());
        $validator = (new Validator($params))
            ->required('name', 'content', 'created_at', 'image', 'slug')
            ->slug('slug')
            ->minLength('name', 4)
            ->minLength('content', 20)
            ->dateTime('created_at')
            ->extension('image', ['jpg', 'png']);

        if ($this->request->getMethod() === 'POST') {
            $validator->uploaded('image');
        }

        $errors = $validator->getErrors();

        if (!empty($errors)) {
            $this->errors = $errors;

            return false;
        }

        return true;
    }

    public function isValid()
    {
        return empty($this->request->getAttribute('errors'));
    }

    /**
     * @return array
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Récupère les paramètres en filtrant.
     *
     * @return array
     */
    public function getParams(): array
    {
        return array_filter($this->request->getParsedBody(), function ($key) {
            return in_array($key, ['name', 'content', 'created_at', 'slug'], true);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * @return ServerRequestInterface
     */
    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }

    public function getAttributes(): array
    {
        return $this->request->getAttributes();
    }
}
