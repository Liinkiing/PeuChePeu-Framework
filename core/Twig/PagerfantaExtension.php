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

    public function paginate(Pagerfanta $paginatedResults, $route, $data = [], $queryParams = [])
    {
        $view = new TwitterBootstrap4View();

        return $view->render($paginatedResults, function ($page) use ($data, $queryParams) {
            if ($page > 1) {
                $queryParams['page'] = $page;
            }

            return $this->router->pathFor('blog.index', $data, $queryParams);
        });
    }
}
