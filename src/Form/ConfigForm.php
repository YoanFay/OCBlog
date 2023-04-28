<?php

namespace App\Src\Form;

use App\Src\Core\Form;
use App\Src\Entity\Config;

class ConfigForm
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
     * @param array  $errors      parameter
     * @param array  $errorsImage parameter
     * @param array  $errorsCv    parameter
     * @param Config $config      parameter
     * @param string $token       parameter
     *
     * @return Form
     */
    public function updateConfig(array $errors, array $errorsImage, array $errorsCv, Config $config, string $token): Form
    {

        $updateForm = $this->form->startForm('post', '/Admin/updateConfig', ['enctype' => 'multipart/form-data'])
            ->addLabelFor('title', "Titre du site")
            ->addTextArea('title', $config->getTitle(), ['class' => 'form-control my-3', 'required' => true])
            ->addError($errors['content'] ?? [])
            ->addLabelFor('catchPhrase', "Phrase d'accroche")
            ->addTextArea('catchPhrase', $config->getCatchPhrase(), ['class' => 'form-control my-3', 'required' => true])
            ->addError($errors['catchPhrase'] ?? []);

        if ($config->getImage()) {
            $updateForm->addImage('config', $config->getImage());
        }

        $updateForm
            ->addLabelFor('image', "Image")
            ->addInput('file', 'image', ['class' => 'form-control my-3', 'id' => 'formImage'])
            ->addError($errorsImage['image'] ?? [])
            ->addLabelFor('cv', "CV")
            ->addInput('file', 'cv', ['class' => 'form-control my-3', 'id' => 'formImage'])
            ->addError($errorsCv['cv'] ?? [])
            ->addInput('submit', 'validate', ['value' => 'Valider', 'class' => 'btn btn-primary me-2'])
            ->addReturn('/Admin')
            ->addHidden('formName', 'updateConfig')
            ->addHidden('csrfToken', $token)
            ->endForm();

        return $updateForm;

    }
}
