<?php

namespace App\Src\Form;

use App\Src\Core\Form;

class AuthentificationForm
{

    private $form;

    public function __construct()
    {
        $this->form = new Form();
    }

    public function signUp($token, $errorFile, $errors)
    {

        return $this->form->startForm('post', 'http://localhost/Authentication/signUp')
            ->addLabelFor('firstname', "Prénom")
            ->addInput('text', 'firstname', ['class' => 'form-control col-6 sign-input', 'id' => 'firstname', 'required' => true])
            ->addError($errors['firstname'] ?? [])
            ->addLabelFor('lastname', "Nom")
            ->addInput('text', 'lastname', ['class' => 'form-control sign-input', 'required' => true])
            ->addError($errors['lastname'] ?? [])
            ->addLabelFor('login', "Login")
            ->addInput('text', 'login', ['class' => 'form-control sign-input', 'required' => true])
            ->addError($errors['login'] ?? [])
            ->addLabelFor('password', "Mot de passe")
            ->addInput('password', 'password', ['class' => 'form-control sign-input', 'required' => true])
            ->addError($errors['password'] ?? [])
            ->addInput('file', 'image', ['class' => 'form-control my-3', 'id' => 'formImage'])
            ->addInput('submit', 'validate', ['value' => 'Valider', 'class' => 'btn btn-primary'])
            ->addError($errorFile['image'] ?? [])
            ->addHidden('formName', 'signUp')
            ->addHidden('csrfToken', $token)
            ->endForm();

    }

    public function signIn($token)
    {

        return $this->form->startForm('post', 'http://localhost/Authentication/signIn', ['class' => 'form-sign'])
            ->addLabelFor('login', "Login")
            ->addInput('text', 'login', ['class' => 'form-control sign-input', 'required' => true])
            ->addLabelFor('password', "Mot de passe")
            ->addInput('password', 'password', ['class' => 'form-control sign-input', 'required' => true])
            ->addInput('submit', 'validate', ['value' => 'Valider', 'class' => 'btn btn-primary btn-block mt-2'])
            ->addHidden('formName', 'signIn')
            ->addHidden('csrfToken', $token)
            ->endForm();

    }

}