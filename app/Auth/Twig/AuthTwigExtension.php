<?php

namespace App\Auth\Twig;

use App\Auth\AuthService;

class AuthTwigExtension extends \Twig_Extension
{
    /**
     * @var AuthService
     */
    private $auth;

    public function __construct(AuthService $auth)
    {
        $this->auth = $auth;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('current_user', [$this->auth, 'user']),
            new \Twig_SimpleFunction('has_role', [$this, 'hasRole'])
        ];
    }

    public function hasRole(string $role): bool
    {
        $user = $this->auth->user();
        if ($user) {
            return $user->hasRole($role);
        }

        return false;
    }
}
