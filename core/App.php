<?php

namespace Core;

class App extends \DI\Bridge\Slim\App
{

    protected function configureContainer(\DI\ContainerBuilder $builder)
    {
        $builder->addDefinitions(__DIR__ . '/config.php');
        $builder->useAnnotations(true);
    }

    /**
     * Permet de rajouter un module dans l'application
     *
     * @param string $module
     */
    public function addModule(string $module) {
        if ($this->getContainer()->has(ModulesContainer::class)) {
            $this->getContainer()->set(ModulesContainer::class, new ModulesContainer($this));
        }
        $this->getContainer()->get(ModulesContainer::class)->add($module);
    }


}
