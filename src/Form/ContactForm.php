<?php

namespace App\Src\Form;

use App\Src\Core\Form;
use App\Src\Entity\Config;

class ContactForm
{

    /**
     * @var Form
     */
    private $form;


    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->form = new Form();
    }

    /**
     * @param array  $errors parameter
     * @param string $token  parameter
     * @return Form
     */
    public function contact(array $errors, string $token): Form
    {
        return $this->form->startForm('post', '/contact')
            ->addLabelFor('name', "Nom et prénom :")
            ->addInput("text", 'name', ['class' => 'form-control', 'required' => true, 'id' => 'name'])
            ->addError($errors['name'] ?? [])
            ->addLabelFor('mail', "E-mail de contact :")
            ->addInput("text", 'mail', ['class' => 'form-control', 'required' => true, 'id' => 'mail'])
            ->addError($errors['recipient'] ?? [])
            ->addLabelFor('message', "Message :")
            ->addTextArea('message', "", ['class' => 'form-control my-3', 'required' => true, 'id' => 'message', 'rows' => 5])
            ->addError($errors['message'] ?? [])
            ->addInput('submit', 'validate', ['value' => 'Valider', 'class' => 'btn btn-primary', 'id' => 'formSubmit'])
            ->addHidden('formName', 'contact')
            ->addHidden('csrfToken', $token);
    }

    /**
     * @param array  $errors parameter
     * @param string $token  parameter
     * @param int    $id     parameter
     * @return Form
     */
    public function answer(array $errors, string $token, int $id): Form
    {
        return $this->form->startForm('post', '/contact/answerContact/'.$id)
            ->addLabelFor('answer', "Réponse :")
            ->addTextArea('answer', "", ['class' => 'form-control my-3', 'required' => true, 'id' => 'message', 'rows' => 5])
            ->addError($errors['answer'] ?? [])
            ->addInput('submit', 'validate', ['value' => 'Valider', 'class' => 'btn btn-primary', 'id' => 'formSubmit'])
            ->addHidden('formName', 'answer')
            ->addHidden('csrfToken', $token);
    }
}
