<?php
/**
 * Définition de la classe Homepage
 */

namespace App\Src\Controller;

use App\Src\Core\Bdd;
use App\Src\Core\Mail;
use App\Src\Entity\Contact;
use App\Src\Form\ContactForm;
use App\Src\Repository\ConfigRepository;
use App\Src\Repository\ContactRepository;
use App\Src\Repository\PostRepository;
use App\Src\Validator\ContactValidator;

class Homepage extends Controller
{
    /**
     * @return void
     */
    public function index()
    {
        $postRepository = new PostRepository();
        $configRepository = new ConfigRepository();

        $config = $configRepository->findOne();
        $posts = $postRepository->findLastPublishedPost();
        $flash = Session::getFlash();
        Session::resetFlash();

        $this->render('homepage/homepage', [
            'image' => $config->getImage(),
            'catch_phrase' => $config->getCatchPhrase(),
            'cv' => $config->getCv(),
            'title' => $config->getTitle(),
            'posts' => $posts,
            'flash' => $flash,
        ]);
    }
}
