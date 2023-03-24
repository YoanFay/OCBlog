<?php

namespace App\Src\Controller;

class Session extends Controller
{


    /**
     * Fonction qui retourne l'utilisateur s'il y en a un
     *
     * @param string|null $key
     * @return mixed|null
     */
    static public function getAuth(string $key=null)
    {
        $session=$_SESSION;

        if (isset($session['auth']) === FALSE) {
            return null;
        }

        return $key ? $session['auth'][$key] : $session['auth'];

        //end getAuth()
    }

    /**
     * Fonction qui enregistre l'utilisateur
     *
     * @param $user
     * @param $role
     * @return void
     */
    static public function setAuth($user, $role)
    {
        $auth=
            [
                'user_id'=>$user->getId(),
                'role_id'=>$role->getId(),
                'role'=>$role->getCode(),
                'level'=>$role->getLevel(),
            ];

        $_SESSION['auth']=$auth;
    }

    /**
     * Fonction qui déconnecte l'utilisateur
     *
     * @return void
     */
    static public function logout(): void
    {
        unset($_SESSION['auth']);
    }

    /**
     * Fonction qui paramètre une flash
     *
     * @param string $type
     * @param string $message
     * @return void
     */
    static public function setFlash(string $type, string $message): void
    {

        $flash=
            [
                'type'=>$type,
                'message'=>$message,
            ];

        $_SESSION['flash']=$flash;
    }

    /**
     * Fonction qui affiche une flash dans le footer s'il y en a
     *
     * @param string|null $key
     * @return mixed|null
     */
    static public function getFlash(string $key=null)
    {
        $session=$_SESSION;

        if (!isset($session['flash'])) {
            return null;
        }

        return $key ? $session['flash'][$key] : $session['flash'];
    }

    /**
     * Fonction qui supprime les flash
     *
     * @return void
     */
    static public function resetFlash(): void
    {
        unset($_SESSION['flash']);
    }

    /**
     * Fonction qui paramètre le token pour les formulaires
     *
     * @param string $token
     * @return void
     */
    static public function setToken(string $token): void
    {
        $_SESSION['token']=$token;
    }

    /**
     * Fonction qui récupère le token pour les formulaires
     *
     * @return mixed|null
     */
    static public function getToken()
    {
        return ($_SESSION['token'] ?? null);
    }

}