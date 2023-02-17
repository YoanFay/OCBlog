<?php

namespace App\Src\Validator;

use App\Src\Entity\User;

class UserValidator extends Validator
{

    private $user;

    public function __construct($user)
    {
        $this->user = $user;
        $this->error = [];
    }

    public function validate()
    {
        $this->firstname($this->user->getFirstname());
        $this->lastname($this->user->getLastname());
        $this->login($this->user->getLogin());
        $this->password($this->user->getPassword());

        if ($this->error === []){
            return true;
        }

        return $this->error;
    }

    public function firstname($parameter)
    {
        if ($this->validateIsNotEmpty($parameter) !== true){
            $this->error['firstname'][] = "L'article ne peut pas être vide.";
        }
        if ($this->validateIsString($parameter) !== true){
            $this->error['firstname'][] = "L'article doit être une chaîne de caractère.";
        }
    }

    public function lastname($parameter)
    {
        if ($this->validateIsNotEmpty($parameter) !== true){
            $this->error['lastname'][] = "L'article ne peut pas être vide.";
        }
        if ($this->validateIsString($parameter) !== true){
            $this->error['lastname'][] = "L'article doit être une chaîne de caractère.";
        }
    }

    public function login($parameter)
    {
        if ($this->validateIsNotEmpty($parameter) !== true){
            $this->error['login'][] = "L'article ne peut pas être vide.";
        }
        if ($this->validateIsString($parameter) !== true){
            $this->error['login'][] = "L'article doit être une chaîne de caractère.";
        }
    }

    public function password($parameter)
    {
        if ($this->validateIsNotEmpty($parameter) !== true){
            $this->error['password'][] = "L'article ne peut pas être vide.";
        }
        if ($this->validateIsString($parameter) !== true){
            $this->error['password'][] = "L'article doit être une chaîne de caractère.";
        }
    }

}