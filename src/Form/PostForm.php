<?php

namespace App\Src\Form;

use App\Src\Core\Form;

class PostForm
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
     * @param array $categoryTab parameter
     * @param array $errors parameter
     * @param array $errorsFile parameter
     * @param string $token parameter
     * @return Form
     */
    public function addPost(array $categoryTab, array $errors, array $errorsFile, string $token): Form
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

    /**
     * @param int $id parameter
     * @param string $token parameter
     * @return Form
     */
    public function deletePost(int $id, string $token): Form
    {

        return $this->form->startForm('post', '/Post/deletePost/'.$id)
            ->addInput('submit', 'validate', ['value' => 'Supprimer', 'class' => 'btn btn-danger me-2'])
            ->addReturn('/Post/onePost/'.$id)
            ->addHidden('formName', 'deletePost')
            ->addHidden('csrfToken', $token)
            ->endForm();

    }

    /**
     * @param int $id parameter
     * @param string $token parameter
     * @return Form
     */
    public function publishPost(int $id, string $token): Form
    {

        return $this->form->startForm('post', '/Post/publishedPost/'.$id)
            ->addInput('submit', 'validate', ['value' => 'Publier', 'class' => 'btn btn-primary me-2'])
            ->addReturn('/Post/onePost/'.$id)
            ->addHidden('formName', 'publishPost')
            ->addHidden('csrfToken', $token)
            ->endForm();

    }

    /**
     * @param array $categoryTab parameter
     * @param array $errors parameter
     * @param int $id parameter
     * @param string $content parameter
     * @param string $token parameter
     * @param string $image parameter
     * @return Form
     */
    public function updatePost(array $categoryTab, array $errors, int $id, string $content, string $token, string $image): Form
    {

        $updateForm = $this->form->startForm('post', '/Post/updatePost/'.$id, ['enctype' => 'multipart/form-data'])
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
