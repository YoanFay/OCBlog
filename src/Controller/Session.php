<?php

namespace App\Src\Controller;

use App\Src\Entity\Role;
use App\Src\Entity\User;

class Session
{


    /**
     * Constructeur
     */
    public function __construct()
    {
        session_start();

    }//end __construct()


    /**
     * Fonction qui retourne l'utilisateur s'il y en a un
     *
     * @param string|null $key parameter
     *
     * @return mixed|null
     */
    public function getAuth(string $key = null)
    {
        $session = $this->getSession();

        if (isset($session['auth']) === FALSE) {
            return null;
        }

        if ($key !== null) {
            return $session['auth'][$key];
        }

        return $session['auth'];

    }//end getAuth()


    /**
     * @return array
     */
    public function getSession(): array
    {
        return $_SESSION;

    }

    /**
     * Fonction qui enregistre l'utilisateur
     *
     * @param User $user parameter
     * @param Role $role parameter
     *
     * @return void
     */
    public function setAuth(User $user, Role $role)
    {
        $auth
            = [
            'user_id' => $user->getId(),
            'role_id' => $role->getId(),
            'role' => $role->getCode(),
            'level' => $role->getLevel(),
        ];

        $this->setSession('auth', $auth);

    }

    /**
     * @param string $key     parameter
     * @param mixed  $content parameter
     *
     * @return void
     */
    public function setSession(string $key, $content)
    {
        $_SESSION[$key] = $content;
    }

    /**
     * Fonction qui déconnecte l'utilisateur
     *
     * @return void
     */
    public function logout(): void
    {
        $this->unsetSession('auth');
    }

    /**
     * @param string $key parameter
     *
     * @return void
     */
    public function unsetSession(string $key)
    {
        unset($_SESSION[$key]);
    }

    /**
     * Fonction qui paramètre une flash
     *
     * @param string $type    parameter
     * @param string $message parameter
     *
     * @return void
     */
    public function setFlash(string $type, string $message): void
    {

        $flash
            = [
            'type' => $type,
            'message' => $message,
        ];

        $this->setSession('flash', $flash);
    }

    /**
     * Fonction qui affiche une flash dans le footer s'il y en a
     *
     * @param string|null $key parameter
     *
     * @return mixed|null
     */
    public function getFlash(string $key = null)
    {
        $session = $this->getSession();

        if (isset($session['flash']) === FALSE) {
            return null;

        }

        if ($key !== null) {
            return $session['flash'][$key];

        }

        return $session['flash'];
    }

    /**
     * Fonction qui supprime les flash
     *
     * @return void
     */
    public function resetFlash(): void
    {
        $this->unsetSession('flash');
    }

    /**
     * Fonction qui paramètre le token pour les formulaires
     *
     * @param string $token parameter
     *
     * @return void
     */
    public function setToken(string $token): void
    {
        $this->setSession('token', $token);
    }

    /**
     * Fonction qui récupère le token pour les formulaires
     *
     * @return mixed|null
     */
    public function getToken()
    {
        $session = $this->getSession();

        return ($session['token'] ?? null);
    }

}
