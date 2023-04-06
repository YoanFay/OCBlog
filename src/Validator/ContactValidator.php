<?php

namespace App\Src\Validator;

use App\Src\Entity\comment;
use App\Src\Entity\Contact;
use App\Src\Repository\CategoryRepository;
use App\Src\Repository\UserRepository;

class ContactValidator extends Validator
{

    /**
     * @var Contact
     */
    private $contact;

    /**
     * @var array
     */
    private $error;


    /**
     * @param Contact $contact parameter
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
        $this->error = [];

    }//end __construct()


    /**
     * @return array|bool
     */
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

    /**
     * @param string $parameter parameter
     * @return void
     */
    public function name(string $parameter)
    {
        if ($this->validateIsNotEmpty($parameter) !== true) {
            $this->error['name'][] = "Le nom ne peut pas être vide.";
        }
        
        if ($this->validateIsString($parameter) !== true) {
            $this->error['name'][] = "Le nom doit être une chaîne de caractère.";
        }
    }

    /**
     * @param string $parameter parameter
     * @return void
     */
    public function mail(string $parameter)
    {
        if ($this->validateIsNotEmpty($parameter) !== true) {
            $this->error['mail'][] = "Le destinataire ne peut pas être vide.";
        }
        if ($this->validateIsString($parameter) !== true) {
            $this->error['mail'][] = "Le destinataire doit être une chaîne de caractère.";
        }
    }

    /**
     * @param string $parameter parameter
     * @return void
     */
    public function message(string $parameter)
    {
        if ($this->validateIsNotEmpty($parameter) !== true) {
            $this->error['message'][] = "Le message ne peut pas être vide.";
        }
        if ($this->validateIsString($parameter) !== true) {
            $this->error['message'][] = "Le message doit être une chaîne de caractère.";
        }
    }

    /**
     * @return array|bool
     */
    public function validateAnswer()
    {
        $this->answer($this->contact->getName());

        if ($this->error === []) {
            return true;
        }

        return $this->error;
    }

    /**
     * @param string $parameter parameter
     * @return void
     */
    public function answer(string $parameter)
    {
        if ($this->validateIsNotEmpty($parameter) !== true) {
            $this->error['answer'][] = "Le message ne peut pas être vide.";
        }
        if ($this->validateIsString($parameter) !== true) {
            $this->error['answer'][] = "Le message doit être une chaîne de caractère.";
        }
    }

}
