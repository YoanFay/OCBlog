<?php

namespace App\Src\Controller;

use App\Src\Core\Bdd;
use App\Src\Core\Form;
use DateTime;

class Authentication extends Controller{

    public function signUp(){

        $form = new Form;

        $form->startForm('post', 'http://localhost/ocBlog/Authentication/addUser')
            ->addLabelFor('firstname', "Prénom")
            ->addInput('text', 'firstname', ['class' => 'form-control col-6', 'id' => 'firstname', 'required' => true])
            ->addLabelFor('lastname', "Nom")
            ->addInput('text', 'lastname', ['class' => 'form-control', 'required' => true])
            ->addLabelFor('login', "Login")
            ->addInput('text', 'login', ['class' => 'form-control', 'required' => true])
            ->addLabelFor('password', "Mot de passe")
            ->addInput('password', 'password', ['class' => 'form-control', 'required' => true])
            ->addInput('submit', 'validate', ['value' => 'Valider', 'class' => 'btn btn-primary'])
            ->endForm()
        ;

        $this->render('authentication/signUp', [
            'form' => $form->create()
        ]);
    }

    public function addUser(){

        $bdd = new Bdd();

        $req = "SELECT id FROM role r WHERE r.code = 'user'";

        $role = $bdd->select($req);

        $infoUser = [
            'firstname' => filter_input(INPUT_POST, 'firstname'),
            'lastname' => filter_input(INPUT_POST, 'lastname'),
            'login' => filter_input(INPUT_POST, 'login'),
            'password' => password_hash(filter_input(INPUT_POST, 'password'), PASSWORD_BCRYPT),
            'created' => date_format(new DateTime(), 'Y-m-d H:i:s'),
            'role' => $role[0]['id']
        ];

        $req = 'INSERT INTO user VALUES(NULL, :lastname, :firstname, :login, :password, :created, :role)';

        $bdd->query($req, $infoUser);

        header('Location: http://localhost/ocBlog/Authentication/signIn');
    }

    public function signIn(){

        $form = new Form;

        $form->startForm('post', 'http://localhost/ocBlog/Authentication/validateUser')
            ->addLabelFor('login', "Login")
            ->addInput('text', 'login', ['class' => 'form-control', 'required' => true])
            ->addLabelFor('password', "Mot de passe")
            ->addInput('password', 'password', ['class' => 'form-control', 'required' => true])
            ->addInput('submit', 'validate', ['value' => 'Valider', 'class' => 'btn btn-primary'])
            ->endForm()
        ;

        $this->render('authentication/signIn', [
            'form' => $form->create()
        ]);
    }

    public function validateUser(){

        $bdd = new Bdd();

        $validateInfo = [
            'login' => filter_input(INPUT_POST, 'login'),
        ];
        $password = filter_input(INPUT_POST, 'password');

        $req = "SELECT * FROM user u WHERE u.login = :login";

        $user = $bdd->select($req, $validateInfo);

        if (password_verify($password, $user[0]['password'])){
            session_start();
            $_SESSION['user'] = $user[0];
            header('Location: http://localhost/ocBlog/');
        }else{
            header('Location: http://localhost/ocBlog/Authentication/signIn');
        }

    }

    public function logout(){
        session_start();
        session_destroy();
            header('Location: http://localhost/ocBlog/');
    }
}