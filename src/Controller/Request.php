<?php

namespace App\Src\Controller;

class Request{

    private $post;
    private $get;
    private $server;

    public function __construct()
    {
        $this->post = $_POST;
        $this->get = $_GET;
        $this->server = $_SERVER;
    }

    public function issetPost(){
        if ($this->post !== []){
            return true;
        }

        return false;
    }

    public function issetGet(){
        if ($this->get !== []){
            return true;
        }

        return false;
    }

    public function get(string $method, string $key){
        return $this->$method[$key]??NULL;
    }
}