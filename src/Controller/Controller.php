<?php

namespace App\Src\Controller;

use Dotenv\Dotenv;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

abstract class Controller
{

    private $loader;
    protected $twig;
    protected $dotenv;

    public function __construct()
    {
        require_once '../vendor/vlucas/phpdotenv/src/Dotenv.php';
        session_start();

        $this->loader = new FilesystemLoader('../templates');

        $this->twig = new Environment($this->loader);

        $this->twig->addGlobal('user', Session::getAuth());

        $this->dotenv = Dotenv::createImmutable('..\\');
        $this->dotenv->load();
    }

    public function valideForm(Request $request, string $formName, string $referer)
    {
        if ($request->issetPost() && $request->get('post', 'formName') === $formName && $request->get('post', 'csrfToken') === Session::getToken() && $request->get('server', 'HTTP_REFERER') === 'http://localhost/' . $referer) {
            return true;
        }

        return false;
    }

    public function render($fichier, array $donnees = [])
    {

        extract($donnees);

        $this->twig->display($fichier . '.html.twig', $donnees);
    }
}