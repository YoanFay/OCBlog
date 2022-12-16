<?php

namespace App\Src\Controller;

class Session extends Controller {

    static public function getAuth(string $key = null){

        if (!isset($_SESSION['auth'])){
            return null;
        }

        return $key?$_SESSION['auth'][$key]:$_SESSION['auth'];
    }

    static public function setAuth($user, $role){
        $_SESSION['auth']['user_id'] = $user->getId();
        $_SESSION['auth']['role_id'] = $role->getId();
        $_SESSION['auth']['role'] = $role->getCode();
        $_SESSION['auth']['level'] = $role->getLevel();
    }

    static public function logout():void
    {
        unset($_SESSION['auth']);
    }

    static public function setFlash(string $type, string $message):void
    {
        $_SESSION['flash']['type'] = $type;
        $_SESSION['flash']['message'] = $message;
    }

    static public function getFlash(string $key = null){

        if (!isset($_SESSION['flash'])){
            return null;
        }

        return $key?$_SESSION['flash'][$key]:$_SESSION['flash'];
    }

    static public function resetFlash():void
    {
        unset($_SESSION['flash']);
    }

    static public function setToken(string $token):void
    {
        $_SESSION['token'] = $token;
    }

    static public function getToken(){
        return $_SESSION['token']??null;
    }

}