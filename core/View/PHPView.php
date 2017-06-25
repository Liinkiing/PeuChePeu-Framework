<?php

namespace Core\View;

class PHPView implements ViewInterface
{
    private $paths = [];

    /**
     * Permet d'enregistrer un namespace pour les vues.
     *
     * @param string $namespace
     * @param string $path
     */
    public function addPath(string $path, string $namespace = 'main'): void
    {
        $this->paths['@' . $namespace] = $path;
    }

    /**
     * Rend une vue.
     *
     * @param string $viewName
     * @param array  $data
     *
     * @return string
     */
    public function render(string $viewName, array $data = []): string
    {
        if (mb_strpos($viewName, '@') === 0) {
            $paths = explode('/', $viewName);
            $path = $this->paths[$paths[0]];
            array_shift($paths);
            $path .= '/' . implode('/', $paths);
        } else {
            $path = $this->paths['@main'] . '/' . $viewName;
        }
        extract($data);
        ob_start();
        include $path . '.php';

        return ob_get_clean();
    }
}
