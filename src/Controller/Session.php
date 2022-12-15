<?php

namespace App\Src\Controller;

class Session extends Controller {

    public function get(string $key){
        return $_SESSION[$key]??NULL;
    }

    public function set(string $key, $content):void
    {
        $_SESSION[$key] = $content;
    }

}