<?php

namespace App\Src\Controller;

use App\Src\Entity\Role;
use App\Src\Entity\User;

class Session extends Controller
{


    /**
     * Fonction qui retourne l'utilisateur s'il y en a un
     *
     * @param string|null $key    parameter
     * @return mixed|null
     */
    public static function getAuth(string $key = null)
    {
        $session = $_SESSION;

        if (isset($session['auth']) === FALSE) {
            return null;
        }

        return $key ? $session['auth'][$key] : $session['auth'];

    }
    //end getAuth()


    /**
     * Fonction qui enregistre l'utilisateur
     *
     * @param User $user    parameter
     * @param Role $role    parameter
     * @return void
     */
    public static function setAuth(User $user, Role $role)
    {
        $auth
            = [
            'user_id' => $user->getId(),
            'role_id' => $role->getId(),
            'role' => $role->getCode(),
            'level' => $role->getLevel(),
        ];

        $_SESSION['auth'] = $auth;
    }

    /**
     * Fonction qui déconnecte l'utilisateur
     *
     * @return void
     */
    public static function logout(): void
    {
        unset($_SESSION['auth']);
    }

    /**
     * Fonction qui paramètre une flash
     *
     * @param string $type    parameter
     * @param string $message    parameter
     * @return void
     */
    public static function setFlash(string $type, string $message): void
    {

        $flash
            = [
            'type' => $type,
            'message' => $message,
        ];

        $_SESSION['flash'] = $flash;
    }

    /**
     * Fonction qui affiche une flash dans le footer s'il y en a
     *
     * @param string|null $key    parameter
     * @return mixed|null
     */
    public static function getFlash(string $key = null)
    {
        $session = $_SESSION;

        if (isset($session['flash']) === FALSE) {
            return null;
        }

        return $key ? $session['flash'][$key] : $session['flash'];
    }

    /**
     * Fonction qui supprime les flash
     *
     * @return void
     */
    public static function resetFlash(): void
    {
        unset($_SESSION['flash']);
    }

    /**
     * Fonction qui paramètre le token pour les formulaires
     *
     * @param string $token    parameter
     * @return void
     */
    public static function setToken(string $token): void
    {
        $_SESSION['token'] = $token;
    }

    /**
     * Fonction qui récupère le token pour les formulaires
     *
     * @return mixed|null
     */
    public static function getToken()
    {
        return ($_SESSION['token'] ?? null);
    }

}
