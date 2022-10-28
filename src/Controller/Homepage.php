<?php
/**
 * Définition de la classe Homepage
 */

namespace App\Src\Controller;

class Homepage extends Controller
{
    /**
     * @return void
     */
    public function index()
    {

        $this->render('homepage/homepage', [
            'a' => 1,
            'b' => 2,
        ]);
    }

}