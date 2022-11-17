<?php
/**
 * Définition de la classe Homepage
 */

namespace App\Src\Controller;

use App\Src\Core\Bdd;

class Homepage extends Controller
{
    /**
     * @return void
     */
    public function index()
    {
        $bdd = new Bdd();

        $req = 'SELECT * FROM config';
        $config = $bdd->select($req);
        $config = $config[0];

        $this->render('homepage/homepage', [
            'image' => $config['image'],
            'catch_phrase' => $config['catch_phrase'],
            'cv' => $config['cv'],
        ]);
    }

}