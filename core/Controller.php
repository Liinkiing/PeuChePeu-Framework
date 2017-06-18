<?php

namespace Core;

use Core\View\ViewInterface;
use DI\Container;
use Psr\Http\Message\ResponseInterface;
use Slim\Flash\Messages;
use Slim\Http\Response;
use Slim\Router;

/**
 * Class Controller.
 */
class Controller
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * Controller constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Permet de rendre une vue.
     *
     * @param string $filename Nom de la vue à rendre
     * @param array  $data     Données à envoyer à la vue
     *
     * @return ResponseInterface|string
     */
    protected function render(string $filename, array $data = []): string
    {
        return $this->container->get(ViewInterface::class)->render($filename, $data);
    }

    /**
     * Renvoie une réponse de redirection.
     *
     * @param string $path
     *
     * @return ResponseInterface
     */
    protected function redirect(string $path): ResponseInterface
    {
        $response = new Response();
        $router = $this->container->get(Router::class);

        return $response->withHeader('Location', $router->pathFor($path));
    }

    /**
     * Envoie un message flash.
     *
     * @param string $type
     * @param string $message
     */
    protected function flash(string $type, string $message): void
    {
        $this->getFlash()->addMessage($type, $message);
    }

    /**
     * Récupère le système de message flash.
     *
     * @return Messages
     */
    protected function getFlash(): Messages
    {
        return $this->container->get(Messages::class);
    }
}
