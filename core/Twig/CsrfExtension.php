<?php

namespace Core\Twig;

use Schnittstabil\Csrf\TokenService\TokenServiceInterface;
use Schnittstabil\Psr7\Csrf\Middleware;

class CsrfExtension extends \Twig_Extension
{
    /**
     * @var TokenServiceInterface
     */
    private $service;

    /**
     * @var string
     */
    private $csrfName;

    public function __construct(string $csrfName, Middleware $middleware)
    {
        $this->service = $middleware->getTokenService();
        $this->csrfName = $csrfName;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('csrf_input', [$this, 'input'], ['is_safe' => ['html']])
        ];
    }

    public function input(): string
    {
        $token = $this->service->generate();
        $name = $this->csrfName;

        return "<input type=\"hidden\" name=\"$name\" value=\"$token\" />";
    }
}
