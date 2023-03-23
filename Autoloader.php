<?php

namespace App;

class Autoloader
{

    static function register()
    {
        spl_autoload_register([
            __CLASS__,
            'autoload'
        ]);
    }

    static function autoload($class)
    {
        if (substr($class, 0, 5) === 'Twig\\') {
            $class = "Vendor\\Twig\\Twig\\Src\\" . substr($class, 5);
        } elseif (substr($class, 0, 7) === 'Dotenv\\') {
            $class = "Vendor\\vlucas\\phpdotenv\\Src\\" . substr($class, 7);
        } elseif (substr($class, 0, 10) === 'PhpOption\\') {
            $class = "Vendor\\PhpOption\\PhpOption\\Src\\PhpOption\\" . substr($class, 10);
        } elseif (substr($class, 0, 26) === 'GrahamCampbell\\ResultType\\') {
            $class = "vendor\\graham-campbell\\result-type\\src\\" . substr($class, 26);
        } elseif (substr($class, 0, 20) === 'PHPMailer\\PHPMailer\\') {
            $class = "Vendor\\PHPMailer\\PHPMailer\\Src\\" . substr($class, 20);
        }
        $class = str_replace(__NAMESPACE__ . '\\', '', $class);
        $file = __DIR__ . '\\' . $class . '.php';

        if (file_exists($file)) {
            require_once $file;
        }

    }
}