<?php
namespace Core\Twig\Extensions;

use Core\ModulesContainer;

/**
 * Permet de rajouter la fonction module_enabled() à Twig
 *
 * @package Core\Twig\Extensions
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

    public function getName()
    {
        return 'module';
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('module_enabled', array($this, 'moduleEnabled')),
        ];
    }

    public function moduleEnabled($moduleName)
    {
        return $this->modules->has($moduleName);
    }
}