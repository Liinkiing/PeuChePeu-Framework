<?php

namespace Core\Twig;

use Pagerfanta\Pagerfanta;
use Pagerfanta\View\TwitterBootstrap4View;
use Slim\Router;

/**
 * Permet de rajouter la pagination.
 */
class PagerfantaExtension extends \Twig_Extension
{
    /**
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('paginate', [$this, 'paginate'], ['is_safe' => ['html']]),
        ];
    }

    public function paginate(Pagerfanta $paginatedResults, string $route, $data = [], $queryParams = [])
    {
        $view = new TwitterBootstrap4View();

        return $view->render($paginatedResults, function ($page) use ($route, $data, $queryParams) {
            if ($page > 1) {
                $queryParams['page'] = $page;
            }

            return $this->router->pathFor($route, $data, $queryParams);
        });
    }
}
