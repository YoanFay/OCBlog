<?php

require_once('../Core/Bdd.php');

use App\Src\Core\Bdd;

$bdd = new Bdd();

$req = "INSERT INTO role VALUES (NULL, :name, :code)";

$infoRole = [
    'name' => "Super Admin",
    'code' => "superAdmin",
    'level' => 99,
];

$bdd->query($req, $infoRole);
$idRole = $bdd->lastInsert();

$infoRole = [
    'name' => "Utilisateur",
    'code' => "user",
    'level' => 10,
];

$bdd->query($req, $infoRole);

$infoAdmin = [
    'lastname' => "Fayolle",
    'firstname' => "Yoan",
    'login' => "yF-OcBlog",
    'password' => password_hash("mDp@dmin", PASSWORD_BCRYPT),
    'created' => date_format(new DateTime(), 'Y-m-d H:i:s'),
    'role' => $idRole
];

$req = 'INSERT INTO user VALUES(NULL, :lastname, :firstname, :login, :password, :created, :role)';

$bdd->query($req, $infoAdmin);

$config = [
    'image' => "photo_Yoan_Fayolle.jpg",
    'phrase' => "Pour un site trop bien",
    'cv' => "cv_Yoan_Fayolle.pdf",
    'title' => "Blog de Yoan Fayolle",
];

$req = 'INSERT INTO config VALUES(NULL, :image, :phrase, :cv)';

$bdd->query($req, $config);

$categoryPro = [
    'name' => "Professionnel",
    'code' => "pro",
];

$categoryPerso = [
    'name' => "Personnel",
    'code' => "perso",
];

$req = 'INSERT INTO category VALUES(NULL, :name, :code)';

$bdd->query($req, $categoryPro);
$bdd->query($req, $categoryPerso);
