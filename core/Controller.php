<?php
namespace Core;

use DI\Container;

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

    public function render (string $filename, array $data): string {
        return $this->container->get(View::class)->render($filename, $data);
    }

}