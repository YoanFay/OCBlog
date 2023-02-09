<?php

namespace App\Src\Form;

use App\Src\Core\Form;

class CommentForm
{

    private $form;

    public function __construct()
    {
        $this->form = new Form();
    }

    public function addComment($postId, $errors, $token)
    {

        return $this->form->startForm('post', '/Post/onePost/' . $postId)
            ->addLabelFor('content', "Contenu")
            ->addTextArea('content', "", ['class' => 'form-control my-3', 'required' => true, 'style' => "resize: none; height: 100px;"])
            ->addError($errors['content'] ?? [])
            ->addInput('submit', 'validate', ['value' => 'Valider', 'class' => 'btn btn-primary', 'id' => 'formSubmit'])
            ->addHidden('formName', 'addComment')
            ->addHidden('csrfToken', $token)
            ->endForm();

    }

    public function deleteComment($id, $token)
    {

        return $this->form->startForm('post', '/Comment/deleteComment/' . $id)
            ->addText('Voulez-vous supprimer ce commentaire ?')
            ->addInput('submit', 'validate', ['value' => 'Supprimer', 'class' => 'btn btn-danger'])
            ->addHidden('formName', 'deleteComment')
            ->addHidden('csrfToken', $token)
            ->endForm();

    }

    public function updateComment($errors, $id, $content, $token)
    {

        $updateForm = $this->form->startForm('post', '/Comment/updateComment/' . $id)
            ->addLabelFor('content', "Contenue")
            ->addTextArea('content', "$content", ['class' => 'form-control my-3', 'required' => true])
            ->addError($errors['content'] ?? [])
            ->addInput('submit', 'validate', ['value' => 'Valider', 'class' => 'btn btn-primary'])
            ->addHidden('formName', 'updateComment')
            ->addHidden('csrfToken', $token)
            ->endForm();

        return $updateForm;

    }

    public function publishComment($id, $token)
    {

        return $this->form->startForm('post', '/Comment/publishedComment/' . $id)
            ->addText('Voulez-vous publié ce commentaire ?')
            ->addInput('submit', 'validate', ['value' => 'Publier', 'class' => 'btn btn-primary'])
            ->addHidden('formName', 'publishComment')
            ->addHidden('csrfToken', $token)
            ->endForm();

    }
}
