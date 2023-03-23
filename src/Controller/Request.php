<?php

namespace App\Src\Controller;

class Request
{

    private $post;
    private $get;
    private $server;
    private $file;

    public function __construct()
    {
        $this->post = $_POST;
        $this->get = $_GET;
        $this->server = $_SERVER;
        $this->env = $_ENV;
        $this->file = $_FILES;
    }

    /**
     * Fonction qui vérifie qu'il y a des données en post
     *
     * @return boolean
     */
    public function issetPost()
    {
        if ($this->post !== []) {
            return true;
        }

        return false;
    }

    /**
     * Fonction qui vérifie qu'il y a des données en get
     *
     * @return boolean
     */
    public function issetGet()
    {
        if ($this->get !== []) {
            return true;
        }

        return false;
    }

    /**
     * Fonction qui retourne les données stockée dans la request
     */
    public function get(string $method, string $key)
    {
        return $this->$method[$key] ?? NULL;
    }
}