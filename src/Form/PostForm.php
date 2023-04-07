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

    }//end __construct()


    /**
     * @param array  $categoryTab parameter
     * @param array  $errors      parameter
     * @param array  $errorsFile  parameter
     * @param string $token       parameter
     *
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
     * @param int    $idPost parameter
     * @param string $token  parameter
     *
     * @return Form
     */
    public function deletePost(int $idPost, string $token): Form
    {

        return $this->form->startForm('post', '/Post/deletePost/'.$idPost)
            ->addInput('submit', 'validate', ['value' => 'Supprimer', 'class' => 'btn btn-danger me-2'])
            ->addReturn('/Post/onePost/'.$idPost)
            ->addHidden('formName', 'deletePost')
            ->addHidden('csrfToken', $token)
            ->endForm();

    }

    /**
     * @param int    $idPost parameter
     * @param string $token  parameter
     *
     * @return Form
     */
    public function publishPost(int $idPost, string $token): Form
    {

        return $this->form->startForm('post', '/Post/publishedPost/'.$idPost)
            ->addInput('submit', 'validate', ['value' => 'Publier', 'class' => 'btn btn-primary me-2'])
            ->addReturn('/Post/onePost/'.$idPost)
            ->addHidden('formName', 'publishPost')
            ->addHidden('csrfToken', $token)
            ->endForm();

    }

    /**
     * @param array       $categoryTab parameter
     * @param array       $errors      parameter
     * @param int         $idPost      parameter
     * @param string      $content     parameter
     * @param string      $token       parameter
     * @param string|null $image       parameter
     *
     * @return Form
     */
    public function updatePost(array $categoryTab, array $errors, int $idPost, string $content, string $token, ?string $image): Form
    {

        $updateForm = $this->form->startForm('post', '/Post/updatePost/'.$idPost, ['enctype' => 'multipart/form-data'])
            ->addLabelFor('content', "Contenue")
            ->addTextArea('content', "$content", ['class' => 'form-control my-3', 'required' => true])
            ->addError($errors['content'] ?? [])
            ->addLabelFor('category', "Catégorie")
            ->addSelect('category', $categoryTab, ['class' => 'form-control my-3', 'required' => true])
            ->addError($errors['category'] ?? []);

        if ($image !== null) {
            $updateForm->addImage('post', $image);
        }

        $updateForm->addInput('file', 'image', ['class' => 'form-control my-3', 'id' => 'formImage']);

        if ($image !== null) {
            $updateForm->addCheckbox('deleteImage', "Supprimer l'image");
        }

        $updateForm->addInput('submit', 'validate', ['value' => 'Valider', 'class' => 'btn btn-primary'])
            ->addHidden('formName', 'updatePost')
            ->addHidden('csrfToken', $token)
            ->endForm();

        return $updateForm;

    }
}
