<?php

require_once('../Core/Bdd.php');

use App\Src\Core\Bdd;

$bdd = new Bdd();

$req = "INSERT INTO role VALUES (NULL, :name, :code)";

$infoRole = [
    'name' => "Super Admin",
    'code' => "superAdmin"
];

$bdd->query($req, $infoRole);
$idRole = $bdd->lastInsert();

$infoAdmin = [
    'lastname' => "Fayolle",
    'firstname' => "Yoan",
    'login' => "yF-OcBlog",
    'password' => md5("mDp@dmin"),
    'created' => date_format(new DateTime(), 'Y-m-d H:i:s'),
    'role' => $idRole
];

$req = 'INSERT INTO user VALUES(NULL, :lastname, :firstname, :login, :password, :created, :role)';

$bdd->query($req, $infoAdmin);

$config = [
    'image' => "photo_Yoan_Fayolle.jpg",
    'phrase' => "Pour un site trop bien",
    'cv' => "cv_Yoan_Fayolle.pdf"
];

$req = 'INSERT INTO config VALUES(NULL, :image, :phrase, :cv)';

$bdd->query($req, $config);
