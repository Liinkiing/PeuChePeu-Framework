<?php

namespace App;

class App extends \DI\Bridge\Slim\App
{
    protected function configureContainer(\DI\ContainerBuilder $builder)
    {
        $builder->addDefinitions(__DIR__.'/config.php');
    }
}
