<?php

namespace App\Src\Controller;

abstract class Controller{


    public function render($fichier, array $donnees = []){

        extract($donnees);

        require_once '../templates/'.$fichier.'.html.twig';
    }
}