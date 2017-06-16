<?php

namespace Core;

class App extends \DI\Bridge\Slim\App
{
    /**
     * @var ModulesContainer
     */
    private $modules;

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
        $this->modules = new ModulesContainer($this);

        $builder->useAnnotations(true);
        $builder->addDefinitions(__DIR__ . '/config.php');
        $builder->addDefinitions([
            ModulesContainer::class => $this->modules
        ]);
        $builder->addDefinitions($this->definitions);
    }
}
