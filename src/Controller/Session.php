<?php

namespace App\Src\Controller;

class Session extends Controller
{

    /**
     * Fonction qui retourne l'utilisateur s'il y en a un
     */
    static public function getAuth(string $key = null)
    {
        $session = $_SESSION;

        if (!isset($session['auth'])) {
            return null;
        }

        return $key ? $session['auth'][$key] : $session['auth'];
    }

    /**
     * Fonction qui enregistre l'utilisateur
     */
    static public function setAuth($user, $role)
    {
        $session['auth']['user_id'] = $user->getId();
        $session['auth']['role_id'] = $role->getId();
        $session['auth']['role'] = $role->getCode();
        $session['auth']['level'] = $role->getLevel();

        $_SESSION['auth'] = $session['auth'];
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
        $session['flash']['type'] = $type;
        $session['flash']['message'] = $message;

        $_SESSION['flash'] = $session['flash'];
    }

    /**
     * Fonction qui affiche une flash dans le footer s'il y en a
     */
    static public function getFlash(string $key = null)
    {
        $session = $_SESSION;

        if (!isset($session['flash'])) {
            return null;
        }

        return $key ? $session['flash'][$key] : $session['flash'];
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