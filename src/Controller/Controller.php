<?php

namespace App\Src\Controller;

use Dotenv\Dotenv;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

abstract class Controller
{

    /**
     * @var Environment
     */
    protected $twig;

    /**
     * @var Dotenv
     */
    protected $dotenv;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var FilesystemLoader
     */
    private $loader;


    /**
     * Constructeur
     */
    public function __construct()
    {
        require_once '../vendor/vlucas/phpdotenv/src/Dotenv.php';
        $this->session = new Session();

        $this->loader = new FilesystemLoader('../templates');

        $this->twig = new Environment($this->loader);

        $this->twig->addGlobal('user', $this->session->getAuth());

        $this->dotenv = Dotenv::createImmutable('..\\');
        $this->dotenv->load();

        //end __construct()
    }


    /**
     * Vérifie que le formulaire est valide
     *
     * @param Request $request  parameter
     * @param string  $formName parameter
     * @param string  $referer  parameter
     * @return bool
     */
    public function valideForm(Request $request, string $formName, string $referer): bool
    {

        if ($request->get('post', 'formName') === $formName && $request->get('post', 'csrfToken') === $this->session->getToken() && $request->get('server', 'HTTP_REFERER') === 'http://localhost/'.$referer) {
            return true;
        }

        return false;
    }


    /**
     * Fonction pour rediriger vers une url
     *
     * @param string $url parameter
     * @return null
     */
    public function redirectTo(string $url)
    {
        header('Location: '.$url);
    }

    /**
     * @param string $fichier parameter
     * @param array  $donnees parameter
     * @return void
     */
    public function render(string $fichier, array $donnees = [])
    {
        try {
            $this->twig->display($fichier.'.html.twig', $donnees);
        } catch (LoaderError|RuntimeError|SyntaxError $e) {
        }
    }
}
