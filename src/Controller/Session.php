<?php

namespace App\Src\Controller;

class Session extends Controller
{

    /**
     * Fonction qui retourne l'utilisateur s'il y en a un
     */
    static public function getAuth(string $key = null)
    {
        var_dump($_SESSION['auth']);
        var_dump(filter_input(INPUT_SESSION, 'auth'));
        if (!isset($_SESSION['auth'])) {
            return null;
        }

        return $key ? $_SESSION['auth'][$key] : $_SESSION['auth'];
    }

    /**
     * Fonction qui enregistre l'utilisateur
     */
    static public function setAuth($user, $role)
    {
        $_SESSION['auth']['user_id'] = $user->getId();
        $_SESSION['auth']['role_id'] = $role->getId();
        $_SESSION['auth']['role'] = $role->getCode();
        $_SESSION['auth']['level'] = $role->getLevel();
    }

    /**
     * Fonction qui déconnecte l'utilisateur
     */
    static public function logout(): void
    {
        unset($_SESSION['auth']);
    }

    /**
     * Fonction qui paramètre une flash
     */
    static public function setFlash(string $type, string $message): void
    {
        $_SESSION['flash']['type'] = $type;
        $_SESSION['flash']['message'] = $message;
    }

    /**
     * Fonction qui affiche une flash dans le footer s'il y en a
     */
    static public function getFlash(string $key = null)
    {

        if (!isset($_SESSION['flash'])) {
            return null;
        }

        return $key ? $_SESSION['flash'][$key] : $_SESSION['flash'];
    }

    /**
     * Fonction qui supprime les flash
     */
    static public function resetFlash(): void
    {
        unset($_SESSION['flash']);
    }

    /**
     * Fonction qui paramètre le token pour les formulaires
     */
    static public function setToken(string $token): void
    {
        $_SESSION['token'] = $token;
    }

    /**
     * Fonction qui récupère le token pour les formulaires
     */
    static public function getToken()
    {
        return $_SESSION['token'] ?? null;
    }

}