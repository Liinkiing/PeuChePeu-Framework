<?php

namespace App\Blog;

use App\Admin\AdminWidgetInterface;
use Core\View\ViewInterface;

/**
 * Widget servant à l'administration.
 */
class BlogWidget implements AdminWidgetInterface
{
    /**
     * @var PostTable
     */
    private $postTable;

    /**
     * @var ViewInterface
     */
    private $view;

    public function __construct(PostTable $postTable, ViewInterface $view)
    {
        $this->postTable = $postTable;
        $this->view = $view;
    }

    public function render(): string
    {
        return $this->view->render('@blog/admin/widget', ['posts_count' => $this->postTable->count()]);
    }
}
