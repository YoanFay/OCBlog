<?php
/**
 * Définition de la classe Homepage
 */

namespace App\Src\Controller;

use App\Src\Core\Bdd;
use App\Src\Repository\ConfigRepository;
use App\Src\Repository\PostRepository;

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
        $posts = $postRepository->findAll();
        $user = Session::get('user');

        $this->render('homepage/homepage', [
            'image' => $config->getImage(),
            'catch_phrase' => $config->getCatchPhrase(),
            'cv' => $config->getCv(),
            'title' => $config->getTitle(),
            'user' => $user,
            'posts' => $posts
        ]);
    }
}
