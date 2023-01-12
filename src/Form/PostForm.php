<?php

namespace App\Src\Form;

use App\Src\Core\Form;

class PostForm{

    private $form;

    public function __construct()
    {
        $this->form = new Form();
    }

    public function addPost($categoryTab, $errors, $token){

        return $this->form->startForm('post', '/Post/add')
            ->addLabelFor('content', "Contenue")
            ->addTextArea('content',"", ['class' => 'form-control my-3', 'required' => true])
            ->addError($errors['content']??[])
            ->addLabelFor('category', "Catégorie")
            ->addSelect('category', $categoryTab, ['class' => 'form-control my-3', 'required' => true])
            ->addError($errors['category']??[])
            ->addInput('file', 'image', ['class' => 'form-control my-3'])
            ->addInput('submit', 'validate', ['value' => 'Valider', 'class' => 'btn btn-primary'])
            ->addHidden('formName', 'addPost')
            ->addHidden('csrfToken', $token)
            ->endForm()
            ;

    }

    public function deletePost($id, $token){

        return $this->form->startForm('post', '/Post/deletePost/'.$id)
            ->addText('Voulez-vous supprimer ce post ?')
            ->addInput('submit', 'validate', ['value' => 'Supprimer', 'class' => 'btn btn-danger'])
            ->addHidden('formName', 'deletePost')
            ->addHidden('csrfToken', $token)
            ->endForm()
            ;

    }

    public function publishPost($id, $token){

        return $this->form->startForm('post', '/Post/publishedPost/'.$id)
            ->addText('Voulez-vous publié ce post ?')
            ->addInput('submit', 'validate', ['value' => 'Publier', 'class' => 'btn btn-primary'])
            ->addHidden('formName', 'publishPost')
            ->addHidden('csrfToken', $token)
            ->endForm()
            ;

    }

    public function updatePost($categoryTab, $errors, $id, $content, $token){

        return $this->form->startForm('post', '/Post/updatePost/'.$id)
            ->addLabelFor('content', "Contenue")
            ->addTextArea('content',"$content", ['class' => 'form-control my-3', 'required' => true])
            ->addError($errors['content']??[])
            ->addLabelFor('category', "Catégorie")
            ->addSelect('category', $categoryTab, ['class' => 'form-control my-3', 'required' => true])
            ->addError($errors['category']??[])
            ->addInput('submit', 'validate', ['value' => 'Valider', 'class' => 'btn btn-primary'])
            ->addHidden('formName', 'updatePost')
            ->addHidden('csrfToken', $token)
            ->endForm()
            ;

    }
}
