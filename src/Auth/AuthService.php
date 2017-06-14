<?php

namespace App\Auth;

use App\Auth\Entity\User;
use App\Auth\Table\UserTable;
use Core\Exception\ValidationException;
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
    private $user = false;

    public function __construct(UserTable $userTable, SessionInterface $session)
    {
        $this->userTable = $userTable;
        $this->session = $session;
    }

    /**
     * Permet d'identifier un utilisateur.
     *
     * @param array $params
     *
     * @throws ValidationException
     *
     * @return User
     */
    public function login(array $params): User
    {
        // On valide les informations
        $validator = new \Cake\Validation\Validator();
        $validator
            ->requirePresence('username')
            ->lengthBetween('username', [4, 50], 'Votre pseudo doit être entre 4 et 50 caractères')
            ->requirePresence('password')
            ->minLength('password', 4);
        $errors = $validator->errors($params);
        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }

        // On valide l'utilisateur
        $user = $this->userTable->findByUsername($params['username']);
        if ($user && $user->checkPassword($params['password'])) {
            $this->session->set('auth.user', $user->id);

            return $user;
        }
        throw new ValidationException(['password' => 'Identifiant ou mot de passe incorrect']);
    }

    /**
     * Récupère un utilisateur depuis la session.
     *
     * @return User|bool
     */
    public function user()
    {
        if ($this->user) {
            return $this->user;
        }
        $user_id = $this->session->get('auth.user');
        if ($user_id) {
            $user = $this->userTable->find($user_id);
            if ($user) {
                $this->user = $user;
            }
        }

        return $this->user;
    }
}
