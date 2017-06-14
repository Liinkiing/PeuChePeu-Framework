<?php
namespace Core;

use App\Auth\AuthService;
use Core\View\ViewInterface;
use DI\Annotation\Inject;
use DI\Container;
use Psr\Http\Message\ResponseInterface;
use Slim\Flash\Messages;
use Slim\Http\Response;

/**
 * Class Controller
 * @package Core
 */
class Controller {

    /**
     * @var Container
     */
    protected $container;

    /**
     * @Inject
     * @var Messages
     */
    protected $flash;

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
     * @return string
     */
    public function render (string $filename, array $data = []): string {
        return $this->container->get(ViewInterface::class)->render($filename, $data);
    }

}