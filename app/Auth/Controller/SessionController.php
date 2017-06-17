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
        return $view->render('@auth/login');
    }

    public function store(Request $request, Response $response, AuthService $auth)
    {
        $username = $request->getParam('username');
        $password = $request->getParam('password');
        $user = $auth->login($username, $password);
        if ($user) {
            $this->getFlash()->addMessage('success', 'Vous êtes maintenant connecté');

            return $response->withAddedHeader('location', '/');
        }
        $this->getFlash()->addMessage('error', 'Mot de passe ou identifiant incorrect');

        return $this->render('@auth/login');
    }

    public function destroy(Response $response, AuthService $auth)
    {
        $auth->logout();
        $this->getFlash()->addMessage('success', 'Vous êtes maintenant déconnecté');

        return $response->withAddedHeader('location', '/');
    }
}
