<?php

namespace App\Src\Form;

use App\Src\Core\Form;

class AuthentificationForm{

    private $form;

    public function __construct()
    {
        $this->form = new Form();
    }

    public function signUp(){

        return $this->form->startForm('post')
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

    }

    public function signIn(){

        return $this->form->startForm('post', 'http://localhost/Authentication/signIn')
            ->addLabelFor('login', "Login")
            ->addInput('text', 'login', ['class' => 'form-control', 'required' => true])
            ->addLabelFor('password', "Mot de passe")
            ->addInput('password', 'password', ['class' => 'form-control', 'required' => true])
            ->addInput('submit', 'validate', ['value' => 'Valider', 'class' => 'btn btn-primary'])
            ->endForm()
        ;

    }

}