<?php
namespace Core;

use DI\Container;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;

/**
 * Class Controller
 * @package Core
 */
class Controller {

    /**
     * @var Container
     */
    private $container;

    /**
     * Controller constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Permet de rendre une vue
     *
     * @param string $filename Nom de la vue à rendre
     * @param array $data Données à envoyer à la vue
     * @return ResponseInterface
     */
    public function render (string $filename, array $data): ResponseInterface {
        $response = new Response();
        $response->write($this->container->get(View::class)->render($filename, $data));
        return $response;
    }

}