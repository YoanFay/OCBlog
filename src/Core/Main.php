<?php

namespace App\Src\Core;

class Main{

    public function start(){
        $uri = $_SERVER['REQUEST_URI'];

        if(!empty($uri) && substr($uri, -1) === "/"){
            $uri = substr($uri, 0, -1);
        }

        echo $uri;
    }

}