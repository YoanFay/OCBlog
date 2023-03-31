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
    /**
     * @var null
     */
    protected static $connect = null;

    /**
     * @var PDO
     */
    public $bdd;


    /**
     * Constructeur
     */
    public function __construct()
    {
        $host = '127.0.0.1';
        $db = 'blog';
        $user = 'root';
        $pass = 'root';


        $dsn = "mysql:host=$host;dbname=$db";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
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

    /**
     * @param string $req    parameter
     * @param array  $params parameter
     * @return void
     */
    public function query(string $req, array $params = [])
    {
        $this->bdd->prepare($req)->execute($params);
    }

    /**
     * @param string $req    parameter
     * @param mixed  $class  parameter
     * @param array  $params parameter
     * @return array|false
     */
    public function select(string $req, $class, array $params = [])
    {
        $query = $this->bdd->prepare($req);
        $query->setFetchMode(PDO::FETCH_CLASS, $class);
        $query->execute($params);
        return $query->fetchAll();
    }

    public function lastInsert()
    {
        return $this->bdd->lastInsertId();
    }
}