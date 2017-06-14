<?php

namespace App\Auth\Controller;

use App\Auth\Authenticable;
use Core\Controller;
use Core\Exception\ValidationException;
use Core\View\ViewInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class SessionController extends Controller
{
    use Authenticable;

    public function create(ViewInterface $view)
    {
        $messages = $this->flash->getMessages();

        return $view->render('@auth/login');
    }

    public function store(Request $request, Response $response)
    {
        try {
            $user = $this->getAuth()->login($request->getParams());
            $this->flash->addMessage('success', 'Vous êtes maintenant connecté');

            return $response->withAddedHeader('location', '/');
        } catch (ValidationException $e) {
            $this->flash->addMessage('error', 'Mot de passe ou identifiant incorrect');

            return $this->render('@auth/login', ['errors' => $e->getErrors()]);
        }
    }
}
