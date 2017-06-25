<?php

namespace App\Auth\Exception;

use Psr\Http\Message\RequestInterface;

class ForbiddenException extends \Exception
{
    /**
     * @var RequestInterface
     */
    public $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
        parent::__construct('Accès à ' . $request->getUri() . ' interdit');
    }
}
