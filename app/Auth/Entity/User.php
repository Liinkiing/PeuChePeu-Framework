<?php

namespace App\Auth\Entity;

class User
{
    public $password;
    public $username;
    public $id;

    public function checkPassword(string $password)
    {
        return password_verify($password, $this->password);
    }
}
