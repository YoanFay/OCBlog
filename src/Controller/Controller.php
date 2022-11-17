<?php

namespace App\Src\Controller;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

abstract class Controller{

    private $loader;
    protected $twig;

    public function __construct()
    {
        $this->loader = new FilesystemLoader('../templates');

        $this->twig = new Environment($this->loader);
    }

    public function render($fichier, array $donnees = []){

        extract($donnees);

        $this->twig->display($fichier.'.html.twig', $donnees);
    }
}