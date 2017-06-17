<?php

namespace Core;

use App\Auth\Exception\ForbiddenException;
use Slim\Flash\Messages;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;

class Handler
{
    /**
     * @var Messages
     */
    private $flash;

    /**
     * @var Router
     */
    private $router;

    public function __construct(Messages $flash, Router $router)
    {
        $this->flash = $flash;
        $this->router = $router;
    }

    public function __invoke(
        Request $request,
        Response $response,
        \Exception $e
    ) {
        if ($e instanceof ForbiddenException) {
            $this->flash->addMessage('error', 'Accès interdit');
            $this->flash->addMessage('redirect', $request->getUri());

            return $response
                ->withAddedHeader(
                    'Location',
                    $this->router->pathFor('auth.login')
                );
        }
    }
}
