<?php

namespace App\Auth\Table;

use App\Auth\Entity\User;
use Core\Database\Database;

class UserTable
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
     * Récupère un utilisateur depuis son ID.
     *
     * @param int $user_id
     *
     * @return User
     */
    public function find(int $user_id): ?User
    {
        return $this->database->fetch(
            'SELECT * FROM users WHERE id = ?',
            [$user_id],
            User::class
        );
    }

    /**
     * Récupère un utilisateur depuis son nom d'utilisateur.
     *
     * @param string $username
     *
     * @return User|null
     */
    public function findByUsername(string $username): ?User
    {
        return $this->database->fetch(
            'SELECT * FROM users WHERE username = ?',
            [$username],
            User::class
        );
    }
}
