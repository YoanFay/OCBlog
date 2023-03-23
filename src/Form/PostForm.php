<?php

namespace App\Src\Form;

use App\Src\Core\Form;

class PostForm
{

    private $form;

    public function __construct()
    {
        $this->form = new Form();
    }

    public function addPost($categoryTab, $errors, $errorsFile, $token)
    {

        return $this->form->startForm('post', '/Post/add', ['enctype' => 'multipart/form-data'])
            ->addLabelFor('content', "Contenue")
            ->addTextArea('content', "", ['class' => 'form-control my-3', 'required' => true])
            ->addError($errors['content'] ?? [])
            ->addLabelFor('category', "Catégorie")
            ->addSelect('category', $categoryTab, ['class' => 'form-control my-3', 'required' => true])
            ->addError($errors['category'] ?? [])
            ->addInput('file', 'image', ['class' => 'form-control my-3', 'id' => 'formImage'])
            ->addError($errorsFile['image'] ?? [])
            ->addInput('submit', 'validate', ['value' => 'Valider', 'class' => 'btn btn-primary', 'id' => 'formSubmit'])
            ->addHidden('formName', 'addPost')
            ->addHidden('csrfToken', $token)
            ->endForm();

    }

    public function deletePost($id, $token)
    {

        return $this->form->startForm('post', '/Post/deletePost/' . $id)
            ->addInput('submit', 'validate', ['value' => 'Supprimer', 'class' => 'btn btn-danger me-2'])
            ->addReturn('/Post/onePost/' . $id)
            ->addHidden('formName', 'deletePost')
            ->addHidden('csrfToken', $token)
            ->endForm();

    }

    public function publishPost($id, $token)
    {

        return $this->form->startForm('post', '/Post/publishedPost/' . $id)
            ->addInput('submit', 'validate', ['value' => 'Publier', 'class' => 'btn btn-primary me-2'])
            ->addReturn('/Post/onePost/' . $id)
            ->addHidden('formName', 'publishPost')
            ->addHidden('csrfToken', $token)
            ->endForm();

    }

    public function updatePost($categoryTab, $errors, $id, $content, $token, $image)
    {

        $updateForm = $this->form->startForm('post', '/Post/updatePost/' . $id, ['enctype' => 'multipart/form-data'])
            ->addLabelFor('content', "Contenue")
            ->addTextArea('content', "$content", ['class' => 'form-control my-3', 'required' => true])
            ->addError($errors['content'] ?? [])
            ->addLabelFor('category', "Catégorie")
            ->addSelect('category', $categoryTab, ['class' => 'form-control my-3', 'required' => true])
            ->addError($errors['category'] ?? []);

        if ($image) {
            $updateForm->addImage('post', $image);
        }

        $updateForm->addInput('file', 'image', ['class' => 'form-control my-3', 'id' => 'formImage']);

        if ($image) {
            $updateForm->addCheckbox('deleteImage', "Supprimer l'image");
        }

        $updateForm->addInput('submit', 'validate', ['value' => 'Valider', 'class' => 'btn btn-primary'])
            ->addHidden('formName', 'updatePost')
            ->addHidden('csrfToken', $token)
            ->endForm();

        return $updateForm;

    }
}
