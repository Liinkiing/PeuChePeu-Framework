<?php

namespace Core;

class App extends \DI\Bridge\Slim\App
{
    /**
     * Extra definitions for the contaienr Builder.
     *
     * @var string|array
     */
    private $definitions;

    public function __construct($definitions = [])
    {
        $this->definitions = $definitions;
        parent::__construct();

        // Middlewares
        $this->add(new \Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware());
        $this->add($this->getContainer()->get('csrf'));
    }

    protected function configureContainer(\DI\ContainerBuilder $builder): void
    {
        // PHP-DI
        $builder->addDefinitions(__DIR__ . '/config.php');
        $builder->addDefinitions($this->definitions);
        $builder->addDefinitions([
            get_class($this) => $this
        ]);
    }
}
