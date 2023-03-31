<?php

namespace App\Src\Repository;

use App\Src\Core\Bdd;
use App\Src\Entity\Config;
use App\Src\Entity\User;
use Exception;

class ConfigRepository
{

    /**
     * @var Bdd
     */
    private $bdd;

    /**
     * @var string
     */
    private $class = Config::class;


    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->bdd = new BDD();
    }

    /**
     * @return mixed|null
     */
    public function findOne()
    {

        $req = 'SELECT * FROM config';

        if ($config = $this->bdd->select($req, $this->class)) {
            return $config[0];
        }
        return NULL;

    }

    /**
     * @param Config $config parameter
     * @return Exception|void
     */
    public function update(Config $config)
    {

        $req = 'UPDATE config SET title = :title, image = :image, catch_phrase = :catch_phrase, cv = :cv WHERE id = :id';

        $configInfo = [
            'id' => $config->getId(),
            'title' => $config->getTitle(),
            'catch_phrase' => $config->getCatchPhrase(),
            'image' => $config->getImage(),
            'cv' => $config->getCv()
        ];

        try {
            $this->bdd->query($req, $configInfo);
        } catch (Exception $e) {
            return $e;
        }
    }
}
