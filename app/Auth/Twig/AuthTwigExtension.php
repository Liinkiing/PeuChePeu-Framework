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
            new \Twig_SimpleFunction('current_user', [$this->auth, 'user'])
        ];
    }
}
