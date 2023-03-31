<?php

namespace App\Src\Controller;

use Dotenv\Dotenv;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

abstract class Controller
{

    /**
     * @var FilesystemLoader
     */
    private $loader;

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
    }

    /**
     * Vérifie que le formulaire est valide
     *
     * @return bool
     */
    public function valideForm(Request $request, string $formName, string $referer)
    {

        if ($request->get('post', 'formName') === $formName && $request->get('post', 'csrfToken') === $this->session->getToken() && $request->get('server', 'HTTP_REFERER') === 'http://localhost/'.$referer) {
            return true;
        }

        return false;
    }

    /**
     * Fonction pour rediriger vers une url
     *
     * @return null
     */
    public function redirectTo($url)
    {
        header('Location: '.$url);
    }

    /**
     * Affiche la page sélectionner
     *
     * @return null
     */
    public function render($fichier, array $donnees = [])
    {

        extract($donnees);

        $this->twig->display($fichier.'.html.twig', $donnees);
    }
}
