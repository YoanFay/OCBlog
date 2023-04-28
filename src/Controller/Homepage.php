<?php
/**
 * Définition de la classe Homepage
 */

namespace App\Src\Controller;

use App\Src\Repository\ConfigRepository;
use App\Src\Repository\PostRepository;

class Homepage extends Controller
{


    /**
     * Page d'accueil
     *
     * @return void
     */
    public function index()
    {
        $postRepository = new PostRepository();
        $configRepository = new ConfigRepository();
        $config = $configRepository->findOne();
        $posts = $postRepository->findLastPublishedPost();
        $flash = $this->session->getFlash();
        $this->session->resetFlash();

        $this->render(
            'homepage/homepage',
            [
                'image' => $config->getImage(),
                'catch_phrase' => $config->getCatchPhrase(),
                'cv' => $config->getCv(),
                'title' => $config->getTitle(),
                'posts' => $posts,
                'flash' => $flash,
            ]
        );

    }//end index()


    /**
     * Page 404
     *
     * @return void
     */
    public function notFound()
    {
        $this->render(
            'homepage/notFound'
        );
    }
}
