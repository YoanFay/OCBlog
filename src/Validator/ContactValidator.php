<?php

namespace App\Src\Validator;

use App\Src\Entity\comment;
use App\Src\Entity\Contact;
use App\Src\Repository\CategoryRepository;
use App\Src\Repository\UserRepository;

class ContactValidator extends Validator
{

    private $contact;

    public function __construct($contact)
    {
        $this->contact = $contact;
        $this->error = [];
    }

    public function validate()
    {
        $this->name($this->contact->getName());
        $this->mail($this->contact->getMail());
        $this->message($this->contact->getMessage());

        if ($this->error === []) {
            return true;
        }

        return $this->error;
    }

    public function name($parameter)
    {
        if ($this->validateIsNotEmpty($parameter) !== true) {
            $this->error['name'][] = "Le nom ne peut pas être vide.";
        }
        if ($this->validateIsString($parameter) !== true) {
            $this->error['name'][] = "Le nom doit être une chaîne de caractère.";
        }
    }

    public function mail($parameter)
    {
        if ($this->validateIsNotEmpty($parameter) !== true) {
            $this->error['mail'][] = "Le destinataire ne peut pas être vide.";
        }
        if ($this->validateIsString($parameter) !== true) {
            $this->error['mail'][] = "Le destinataire doit être une chaîne de caractère.";
        }
    }

    public function message($parameter)
    {
        if ($this->validateIsNotEmpty($parameter) !== true) {
            $this->error['message'][] = "Le message ne peut pas être vide.";
        }
        if ($this->validateIsString($parameter) !== true) {
            $this->error['message'][] = "Le message doit être une chaîne de caractère.";
        }
    }

}