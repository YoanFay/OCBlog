<?php

namespace App\Src\Repository;

use App\Src\Core\Bdd;
use App\Src\Entity\Config;
use App\Src\Entity\User;
use Exception;

class ConfigRepository{

    private $bdd;
    private $class = Config::class;

    public function __construct(){
        $this->bdd = new BDD();
    }

    public function findOne()
    {

        $req = 'SELECT * FROM config';

        if ($config = $this->bdd->select($req, $this->class)) {
            return $config[0];
        } else {
            return NULL;
        }

    }
}
