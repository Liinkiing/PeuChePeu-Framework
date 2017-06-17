<?php

namespace App\Auth\Controller;

use App\Auth\AuthService;
use Core\Controller;
use Core\View\ViewInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class SessionController extends Controller
{
    public function create(ViewInterface $view)
    {
        $redirectMessages = $this->getFlash()->getMessage('redirect');
        $redirect = count($redirectMessages) > 0 ? $redirectMessages[0] : null;

        return $view->render('@auth/login', compact('redirect'));
    }

    public function store(Request $request, Response $response, AuthService $auth)
    {
        $username = $request->getParam('username');
        $password = $request->getParam('password');
        $redirect = $request->getParam('redirect');
        $user = $auth->login($username, $password);
        if ($user) {
            $this->getFlash()->addMessage('success', 'Vous êtes maintenant connecté');

            return $response->withAddedHeader('location', $redirect ?: '/');
        }
        $this->getFlash()->addMessage('error', 'Mot de passe ou identifiant incorrect');

        return $this->render('@auth/login', compact('redirect'));
    }

    public function destroy(Response $response, AuthService $auth)
    {
        $auth->logout();
        $this->getFlash()->addMessage('success', 'Vous êtes maintenant déconnecté');

        return $response->withAddedHeader('location', '/');
    }
}
