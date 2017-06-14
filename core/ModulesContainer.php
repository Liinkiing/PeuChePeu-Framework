<?php

namespace Core;

/**
 * Permet de sauvegarder les modules chargés dans l'application
 *
 * @package Core
 */
class ModulesContainer
{

    /**
     * @var array
     */
    private $modules = [];

    /**
     * @var App
     */
    private $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * Permet de rajouter un module dans l'application
     *
     * @param string $module
     */
    public function add(string $module)
    {
        $module = new $module($this->app);
        $moduleName = (new \ReflectionClass($module))->getShortName();
        $this->modules[$moduleName] = $module;
    }

    /**
     * Permet de savoir si un module est actuellement enregistré dans l'application
     *
     * @param string $module
     * @return bool
     */
    public function has(string $module): bool
    {
        return array_key_exists($module, $this->modules);
    }

    /**
     * Liste les différents dossiers de migrations des modules chargés dans l'application
     */
    public function getMigrations(): array
    {
        $migrations = [];
        foreach ($this->modules as $module) {
            if (property_exists($module, 'migrations')) {
                $migrations[] = $module->migrations;
            }
        }
        return $migrations;
    }

    /**
     * Liste les différents dossiers de seeders des modules chargés dans l'application
     */
    public function getSeeders(): array
    {
        $seeds = [];
        foreach ($this->modules as $module) {
            if (property_exists($module, 'seeds')) {
                $seeds[] = $module->seeds;
            }
        }
        return $seeds;
    }

}