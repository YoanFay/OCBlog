<?php

namespace App\Src\Controller;

class Request
{

    /**
     * @var array
     */
    private $file;


    /**
     * Constructeur
     */
    public function __construct()
    {

        $this->file = $_FILES;

    }//end __construct()


    /**
     * Fonction qui retourne les données stockée dans la request
     *
     * @param string $method parameter
     * @param string $key    parameter
     *
     * @return mixed|null
     */
    public function get(string $method, string $key)
    {

        switch ($method) {
        case 'post':
            return filter_input(INPUT_POST, $key);
        case 'get':
            return filter_input(INPUT_GET, $key);
        case 'server':
            return filter_input(INPUT_SERVER, $key);
        case 'env':
            return $_ENV[$key];
        case 'file':
            return $this->file[$key];
        default:
            return NULL;
        }

    }

}
