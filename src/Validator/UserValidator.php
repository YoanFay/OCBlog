<?php

namespace App\Src\Validator;

use App\Src\Entity\User;

class UserValidator extends Validator
{

    /**
     * @var User
     */
    private $user;

    /**
     * @var array
     */
    private $error;


    /**
     * @param User $user parameter
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->error = [];
    }

    /**
     * @return array|bool
     */
    public function validate()
    {
        $this->firstname($this->user->getFirstname());
        $this->lastname($this->user->getLastname());
        $this->login($this->user->getLogin());
        $this->password($this->user->getPassword());

        if ($this->error === []) {
            return true;
        }

        return $this->error;
    }

    /**
     * @param string $parameter parameter
     *
     * @return void
     */
    public function firstname(string $parameter)
    {
        if ($this->validateIsNotEmpty($parameter) !== true) {
            $this->error['firstname'][] = "L'article ne peut pas être vide.";
        }
        if ($this->validateIsString($parameter) !== true) {
            $this->error['firstname'][] = "L'article doit être une chaîne de caractère.";
        }
    }

    /**
     * @param string $parameter parameter
     *
     * @return void
     */
    public function lastname(string $parameter)
    {
        if ($this->validateIsNotEmpty($parameter) !== true) {
            $this->error['lastname'][] = "L'article ne peut pas être vide.";
        }
        if ($this->validateIsString($parameter) !== true) {
            $this->error['lastname'][] = "L'article doit être une chaîne de caractère.";
        }
    }

    /**
     * @param string $parameter parameter
     *
     * @return void
     */
    public function login(string $parameter)
    {
        if ($this->validateIsNotEmpty($parameter) !== true) {
            $this->error['login'][] = "L'article ne peut pas être vide.";
        }
        if ($this->validateIsString($parameter) !== true) {
            $this->error['login'][] = "L'article doit être une chaîne de caractère.";
        }
    }

    /**
     * @param string $parameter parameter
     *
     * @return void
     */
    public function password(string $parameter)
    {
        if ($this->validateIsNotEmpty($parameter) !== true) {
            $this->error['password'][] = "L'article ne peut pas être vide.";
        }
        if ($this->validateIsString($parameter) !== true) {
            $this->error['password'][] = "L'article doit être une chaîne de caractère.";
        }
    }

}
