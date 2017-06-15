<?php

namespace Core\Twig\Extensions;

use Core\ModulesContainer;

/**
 * Permet de rajouter la fonction module_enabled() à Twig.
 */
class ModuleExtension extends \Twig_Extension
{
    /**
     * @var ModulesContainer
     */
    private $modules;

    public function __construct(ModulesContainer $modules)
    {
        $this->modules = $modules;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('module_enabled', [$this->modules, 'has']),
        ];
    }
}
