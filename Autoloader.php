<?php

namespace App;

class Autoloader
{

    /**
     * Fonction Register de l'Autoloader
     */
    public static function register()
    {
        spl_autoload_register(
            [
                __CLASS__,
                'autoload',
            ]
        );
    }


    /**
     * Autoload
     */
    public static function autoload($class)
    {
        $vendorPaths = [
            'Twig\\' => 'Vendor\\Twig\\Twig\\Src\\',
            'Dotenv\\' => 'Vendor\\vlucas\\phpdotenv\\Src\\',
            'PhpOption\\' => 'Vendor\\PhpOption\\PhpOption\\Src\\PhpOption\\',
            'GrahamCampbell\\ResultType\\' => 'vendor\\graham-campbell\\result-type\\src\\',
            'PHPMailer\\PHPMailer\\' => 'Vendor\\PHPMailer\\PHPMailer\\Src\\',
        ];

        foreach ($vendorPaths as $namespace => $vendorPath) {
            if (strpos($class, $namespace) === 0) {
                $class = $vendorPath . substr($class, strlen($namespace));
                break;
            }
        }

        $class = str_replace(__NAMESPACE__ . '\\', '', $class);
        $file = __DIR__ . '\\' . $class . '.php';

        if (is_file($file)) {
            include_once $file;
        }
    }
}
