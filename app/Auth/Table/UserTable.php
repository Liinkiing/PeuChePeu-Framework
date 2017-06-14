<?php

namespace App\Auth\Table;

use App\Auth\Entity\User;

class UserTable
{
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function find(int $user_id): User
    {
        $sth = $this->pdo->prepare('SELECT * FROM users WHERE id = ?');
        $sth->execute([$user_id]);
        $sth->setFetchMode(\PDO::FETCH_CLASS, User::class);

        return $sth->fetch();
    }

    public function findByUsername(string $username): User
    {
        $sth = $this->pdo->prepare('SELECT * FROM users WHERE username = :username');
        $sth->execute(['username' => $username]);
        $sth->setFetchMode(\PDO::FETCH_CLASS, User::class);

        return $sth->fetch();
    }
}
