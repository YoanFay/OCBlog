<?php

namespace App\Src\Core;

use App\Src\Entity\Post;
use Exception;
use PDO;

/**
 * Définition de la classe Base qui crée les liens vers la base de données
 * La classe sera appelée à chaque fois qu'une donnée de la base de données sera nécessaire
 */
class Bdd
{
    protected static $connect = null;
    public $bdd;

    public function __construct()
    {
        $host = '127.0.0.1';
        $db   = 'blog';
        $user = 'root';
        $pass = 'root';


        $dsn = "mysql:host=$host;dbname=$db";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $this->bdd = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    //----------------------------------------
    //FONCTIONS
    //----------------------------------------

    public function query($req, $params = [])
    {
        $this->bdd->prepare($req)->execute($params);
    }

    public function select($req, $class, $params = [])
    {
        $query = $this->bdd->prepare($req);
        $query->setFetchMode(PDO::FETCH_CLASS, $class);
        $query->execute($params);
        return $query->fetchAll();
    }

    public function lastInsert(){
        return $this->bdd->lastInsertId();
    }
}