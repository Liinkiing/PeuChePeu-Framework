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

    public function find(int $user_id): User
    {
        return $this->database->fetch(
            'SELECT * FROM users WHERE id = ?',
            [$user_id],
            User::class
        );
    }

    public function findByUsername(string $username): User
    {
        return $this->database->fetch(
            'SELECT * FROM users WHERE username = ?',
            [$username],
            User::class
        );
    }
}
