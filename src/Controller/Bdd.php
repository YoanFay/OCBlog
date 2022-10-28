<?php

/**
 * Définition de la classe Base qui crée les liens vers la base de données
 * La classe sera appelée à chaque fois qu'une donnée de la base de données sera nécessaire
 */
class Bdd
{
    private static $connect = null;
    private $bdd;

    private function __construct()
    {
        $serveur = "localhost";
        $login = "root";
        $password = "root";
        $base = "blog";


        //Création d'un lien à la base de données de type PDO
        try {
            $this->bdd = new PDO('mysql:host=' . $serveur . ';dbname=' . $base, $login, $password);
            $this->bdd->exec('SET NAMES UTF8');
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (is_null(self::$connect)) {
            self::$connect = new Bdd();
        }
        return self::$connect;
    }

    //----------------------------------------
    //FONCTIONS
    //----------------------------------------

    // Permet de préparer une requête SQL. Retourne la requête préparée sous forme d'objet
    public function prepare($req)
    {
        $query = $this->bdd->prepare($req);
        return $query;
    }

    // Permet d'exécuter une requête SQL préparée. Retourne le résultat (s'il y en a un) de la requête sous forme d'objet
    public function execute($query, $param)
    {
        $req = $query->execute($param);
        return $req;
    }
}