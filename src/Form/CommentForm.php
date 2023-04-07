<?php

namespace App\Src\Form;

use App\Src\Core\Form;

class CommentForm
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
     * @param int    $postId parameter
     * @param array  $errors parameter
     * @param string $token  parameter
     *
     * @return Form
     */
    public function addComment(int $postId, array $errors, string $token): Form
    {

        return $this->form->startForm('post', '/Post/onePost/'.$postId)
            ->addLabelFor('content', "Contenu")
            ->addTextArea('content', "", ['class' => 'form-control my-3', 'required' => true, 'style' => "resize: none; height: 100px;"])
            ->addError($errors['content'] ?? [])
            ->addInput('submit', 'validate', ['value' => 'Valider', 'class' => 'btn btn-primary', 'id' => 'formSubmit'])
            ->addHidden('formName', 'addComment')
            ->addHidden('csrfToken', $token)
            ->endForm();

    }

    /**
     * @param int    $id     parameter
     * @param string $token  parameter
     * @param int    $idPost parameter
     *
     * @return Form
     */
    public function deleteComment(int $id, string $token, int $idPost): Form
    {

        return $this->form->startForm('post', '/Comment/deleteComment/'.$id)
            ->addInput('submit', 'validate', ['value' => 'Supprimer', 'class' => 'btn btn-danger me-2'])
            ->addReturn('/Comment/moderateComment/'.$idPost)
            ->addHidden('formName', 'deleteComment')
            ->addHidden('csrfToken', $token)
            ->endForm();

    }

    /**
     * @param array  $errors  parameter
     * @param int    $id      parameter
     * @param string $content parameter
     * @param string $token   parameter
     * @param string $return  parameter
     *
     * @return Form
     */
    public function updateComment(array $errors, int $id, string $content, string $token, string $return): Form
    {

        return $this->form->startForm('post', '/Comment/updateComment/'.$id)
            ->addLabelFor('content', "Contenue")
            ->addTextArea('content', "$content", ['class' => 'form-control my-3', 'required' => true])
            ->addError($errors['content'] ?? [])
            ->addInput('submit', 'validate', ['value' => 'Valider', 'class' => 'btn btn-primary me-2'])
            ->addReturn($return)
            ->addHidden('formName', 'updateComment')
            ->addHidden('csrfToken', $token)
            ->endForm();

    }

    /**
     * @param int    $id     parameter
     * @param string $token  parameter
     * @param int    $idPost parameter
     *
     * @return Form
     */
    public function publishComment(int $id, string $token, int $idPost): Form
    {

        return $this->form->startForm('post', '/Comment/publishedComment/'.$id)
            ->addInput('submit', 'validate', ['value' => 'Publier', 'class' => 'btn btn-primary me-2'])
            ->addReturn('/Comment/moderateComment/'.$idPost)
            ->addHidden('formName', 'publishComment')
            ->addHidden('csrfToken', $token)
            ->endForm();

    }
}
