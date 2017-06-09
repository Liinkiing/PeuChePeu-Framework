<?php

namespace App\Blog\Repository;

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
}
