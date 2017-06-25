<?php

namespace App\Auth\Entity;

class User
{
    public $password;
    public $username;
    public $id;

    /**
     * @var array Liste les rôles de l'utilisateur
     */
    public $roles = [];

    public function __construct()
    {
        $this->roles = ['admin'];
    }

    public function checkPassword(string $password)
    {
        return password_verify($password, $this->password);
    }

    public function hasRole(string $role): bool
    {
        return in_array($role, $this->roles, true);
    }
}
