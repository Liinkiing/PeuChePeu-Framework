<?php

namespace App\Blog\Table;

use Core\Database\NoRecordException;
use Core\Database\PaginatedQuery;
use Core\Database\Table;

/**
 * Permet de récupérer les articles depuis la base de données.
 */
class PostTable extends Table
{
    protected const TABLE = 'posts';

    public function findPaginated($perPage = 10, $currentPage = 1)
    {
        $count = $this->database->fetchColumn('SELECT COUNT(id) FROM posts');

        return (new PaginatedQuery($this->database, 'SELECT * FROM posts ORDER BY created_at DESC', $count))
            ->getPaginator()
            ->setCurrentPage($currentPage)
            ->setMaxPerPage($perPage);
    }

    /**
     * Récupère un enregistrement à partir de son slug.
     *
     * @param string $slug
     *
     * @throws NoRecordException
     *
     * @return mixed
     */
    public function findBySlug(string $slug)
    {
        $result = $this->database->fetch('SELECT * FROM posts WHERE slug = ?', [$slug]);
        if ($result === false) {
            throw new NoRecordException();
        }

        return $result;
    }
}
