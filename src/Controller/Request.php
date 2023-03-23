<?php

namespace App\Src\Controller;

class Request
{
    private $file;

    public function __construct()
    {
        $this->file = &$_FILES;
    }

    /**
     * Fonction qui retourne les données stockée dans la request
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
                return filter_input(INPUT_ENV, $key);
            case 'file':
                return $this->file[$key];
            default:
                return NULL;
        }
    }
}