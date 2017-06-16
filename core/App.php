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
    }

    protected function configureContainer(\DI\ContainerBuilder $builder)
    {
        $builder->useAnnotations(true);
        $builder->addDefinitions(__DIR__ . '/config.php');
        $builder->addDefinitions($this->definitions);
    }
}
