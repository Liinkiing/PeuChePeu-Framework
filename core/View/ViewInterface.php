<?php

namespace Core\View;

/**
 * Class View
 * Permet d'intéragir avec la gestion de template (ici Twig).
 */
interface ViewInterface
{
    /**
     * Permet d'enregistrer un namespace pour les vues.
     *
     * @param string $namespace
     * @param string $path
     */
    public function addPath(string $path, $namespace);

    /**
     * Rend une vue.
     *
     * @param string $viewName
     * @param array  $data
     *
     * @return string
     */
    public function render(string $viewName, array $data = []): string;
}
