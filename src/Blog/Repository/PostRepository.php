<?php

namespace App\Blog\Repository;

use Core\Database\PaginatedQuery;
use Pagerfanta\Adapter\AdapterInterface;

/**
 * Permet de récupérer les articles depuis la base de données.
 */
class PostRepository
{
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Récupère les derniers articles.
     *
     * @return \PDOStatement
     */
    public function getPosts()
    {
        return $this->pdo->query('SELECT * FROM posts');
    }

    public function getPaginatedPosts($perPage = 10, $currentPage = 1) {
        $count = $this->pdo->query('SELECT COUNT(id) FROM posts')->fetchColumn();
        return (new PaginatedQuery($this->pdo, 'SELECT * FROM posts', $count))
            ->getPaginator()
            ->setCurrentPage($currentPage)
            ->setMaxPerPage($perPage);
    }

}
