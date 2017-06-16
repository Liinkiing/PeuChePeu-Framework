<?php

namespace App\Auth;

use App\Auth\Entity\User;
use App\Auth\Table\UserTable;
use Core\Session\SessionInterface;

class AuthService
{
    /**
     * @var UserTable
     */
    private $userTable;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var User
     */
    private $user = null;

    public function __construct(UserTable $userTable, SessionInterface $session)
    {
        $this->userTable = $userTable;
        $this->session = $session;
    }

    /**
     * Permet d'identifier un utilisateur.
     *
     * @param string $username
     * @param string $password
     *
     * @return User|bool
     */
    public function login(?string $username, ?string $password): ?User
    {
        // On valide les informations
        if (empty($username) || empty($password)) {
            return null;
        }

        // On valide l'utilisateur
        $user = $this->userTable->findByUsername($username);
        if ($user && $user->checkPassword($password)) {
            $this->session->set('auth.user', $user->id);

            return $user;
        }

        return null;
    }

    /**
     * Récupère un utilisateur depuis la session.
     *
     * @return User|bool
     */
    public function user(): ?User
    {
        if ($this->user) {
            return $this->user;
        }
        $user_id = $this->session->get('auth.user');
        if ($user_id) {
            $user = $this->userTable->find($user_id);
            if ($user) {
                $this->user = $user;
            } else {
                $this->session->delete('auth.user');
            }
        }

        return $this->user;
    }

    /**
     * Déconnecte un utilisateur de l'application.
     */
    public function logout()
    {
        $this->session->delete('auth.user');
        $this->user = null;
    }
}
