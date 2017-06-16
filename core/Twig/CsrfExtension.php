<?php

namespace Core\Twig;

use Slim\Csrf\Guard;

class CsrfExtension extends \Twig_Extension
{
    /**
     * @var Guard
     */
    private $csrf;

    public function __construct(Guard $guard)
    {
        $this->csrf = $guard;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('csrf_input', [$this, 'input'], ['is_safe' => ['html']])
        ];
    }

    public function input(): string
    {
        $nameKey = $this->csrf->getTokenNameKey();
        $valueKey = $this->csrf->getTokenValueKey();
        $name = $this->csrf->getTokenName();
        $value = $this->csrf->getTokenValue();

        return '
            <input type="hidden" name="' . $nameKey . '" value="' . $name . '">
            <input type="hidden" name="' . $valueKey . '" value="' . $value . '">
        ';
    }
}
