<?php

namespace App;

class Autoloader{

    static function register(){
        spl_autoload_register([
            __CLASS__,
            'autoload'
        ]);
    }

    static function autoload($class){
        if (substr($class,0,5) === 'Twig\\'){
            $class = "Vendor\\Twig\\Twig\\Src\\".substr($class,5);
        }
        $class = str_replace(__NAMESPACE__ . '\\', '', $class);
        $file = __DIR__ . '\\' . $class . '.php';

        if (file_exists($file)){
            require_once $file;
        }

    }
}