<?php

namespace Core;

class App extends \DI\Bridge\Slim\App
{
    /**
     * Ajoute une définition au chargement.
     *
     * @var string|array
     */
    private $definitions;

    /**
     * Liste tous les modules disponibles dans l'application.
     *
     * @var array
     */
    private $modules;

    public function __construct($definitions = [], array $modules = [])
    {
        $this->definitions = $definitions;
        $this->modules = $modules;

        // On construit le conteneur
        parent::__construct();

        // On charge les modules
        foreach ($modules as $module) {
            $this->getContainer()->get($module);
        }

        // Middlewares
        $this->add($this->getContainer()->get('csrf'));
    }

    /**
     * Récupère la liste des modules disponibles.
     *
     * @return array
     */
    public function getModules(): array
    {
        return $this->modules;
    }

    /**
     * Permet de configurer le conteneur d'injection de dépendances.
     *
     * @param \DI\ContainerBuilder $builder
     */
    protected function configureContainer(\DI\ContainerBuilder $builder): void
    {
        // PHP-DI
        $builder->addDefinitions(__DIR__ . '/config.php');
        $builder->addDefinitions($this->definitions);
        $builder->addDefinitions([
            get_class($this) => $this
        ]);
        foreach ($this->modules as $module) {
            if ($module::DEFINITIONS) {
                $builder->addDefinitions($module::DEFINITIONS);
            }
        }
    }
}
