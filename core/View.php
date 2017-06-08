<?php

namespace Core;

class View
{

    /**
     * @var string
     */
    private $basepath;

    /**
     * @var \Twig_Loader_Filesystem
     */
    private $loader;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct(string $basepath)
    {
        $this->basepath = $basepath;
        $this->loader = new \Twig_Loader_Filesystem($basepath . '/src/Base/views');
        $this->twig = new \Twig_Environment($this->loader, [
            'cache' => false, // $basepath . '/tmp/cache'
        ]);
    }

    public function registerNamespace(string $namespace, string $path)
    {
        $this->loader->addPath($path, $namespace);
    }

    public function render (string $viewName, array $data): string {
        return $this->twig->render($viewName, $data);
    }

}