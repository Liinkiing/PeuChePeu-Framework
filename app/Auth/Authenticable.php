<?php

namespace App\Auth;

trait Authenticable
{
    public function getAuth(): AuthService
    {
        return $this->container->get(AuthService::class);
    }
}
