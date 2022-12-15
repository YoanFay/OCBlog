<?php

namespace App\Src\Form;

use App\Src\Core\Form;

class PostForm{

    private $form;

    public function __construct()
    {
        $this->form = new Form();
    }

    public function addPost($categoryTab, $errors){

        return $this->form->startForm('post', 'http://localhost/Post/add')
            ->addLabelFor('content', "Contenue")
            ->addTextArea('content',"", ['class' => 'form-control my-3', 'required' => true])
            ->addError($errors['content']??[])
            ->addLabelFor('category', "Catégorie")
            ->addSelect('category', $categoryTab, ['class' => 'form-control my-3', 'required' => true])
            ->addError($errors['category']??[])
            ->addInput('submit', 'validate', ['value' => 'Valider', 'class' => 'btn btn-primary'])
            ->endForm()
        ;

    }
}
