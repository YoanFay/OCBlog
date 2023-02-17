<?php

namespace App\Src\Form;

use App\Src\Core\Form;
use App\Src\Entity\Config;

class ConfigForm
{

    private $form;

    public function __construct()
    {
        $this->form = new Form();
    }

    public function updateComment($errors, $errorsImage, $errorsCv, Config $config, $token)
    {

        $updateForm = $this->form->startForm('post', '/Admin/updateConfig/' . $config->getId(), ['enctype' => 'multipart/form-data'])
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
            ->addInput('submit', 'validate', ['value' => 'Valider', 'class' => 'btn btn-primary'])
            ->addHidden('formName', 'updateConfig')
            ->addHidden('csrfToken', $token)
            ->endForm();

        return $updateForm;

    }
}
