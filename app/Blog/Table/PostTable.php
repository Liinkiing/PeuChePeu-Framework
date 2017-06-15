<?php

namespace App\Blog\Table;

use Core\Database\Database;
use Core\Database\NoRecordException;
use Core\Database\PaginatedQuery;

/**
 * Permet de récupérer les articles depuis la base de données.
 */
class PostTable
{
    /**
     * @var Database
     */
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * Récupère les derniers articles.
     *
     * @return array
     */
    public function getPosts(): array
    {
        return $this->database->fetchAll('SELECT * FROM posts');
    }

    public function getPaginatedPosts($perPage = 10, $currentPage = 1)
    {
        $count = $this->database->fetchColumn('SELECT COUNT(id) FROM posts');

        return (new PaginatedQuery($this->database, 'SELECT * FROM posts', $count))
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
