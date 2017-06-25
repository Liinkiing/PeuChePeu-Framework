<?php

namespace App\Auth\Middleware;

use App\Auth\Exception\ForbiddenException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class RoleMiddleware
{
    /**
     * @var string
     */
    private $role;
    /**
     * @var \App\Auth\AuthService
     */
    private $auth;

    public function __construct(\App\Auth\AuthService $auth, string $role)
    {
        $this->role = $role;
        $this->auth = $auth;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next): ResponseInterface
    {
        $user = $this->auth->user();
        if ($user && $user->hasRole($this->role)) {
            return $response = $next($request, $response);
        }
        $forbiddenException = new ForbiddenException($request);
        $forbiddenException->request = $request;
        throw $forbiddenException;
    }
}
