<?php

namespace App\Src\Validator;

use App\Src\Entity\Config;

class ConfigValidator extends Validator
{

    private $config;

    public function __construct($config)
    {
        $this->config = $config;
        $this->error = [];
    }

    public function validate()
    {
        $this->title($this->config->getTitle());
        $this->catchPhrase($this->config->getCatchPhrase());

        if ($this->error === []){
            return true;
        }

        return $this->error;
    }

    public function title($parameter)
    {
        if ($this->validateIsNotEmpty($parameter) !== true){
            $this->error['content'][] = "Le titre ne peut pas être vide.";
        }
        if ($this->validateIsString($parameter) !== true){
            $this->error['content'][] = "Le titre doit être une chaîne de caractère.";
        }
    }

    public function catchPhrase($parameter)
    {
        if ($this->validateIsNotEmpty($parameter) !== true){
            $this->error['catchPhrase'][] = "La phrase d'accroche ne peut pas être vide.";
        }
        if ($this->validateIsString($parameter) !== true){
            $this->error['catchPhrase'][] = "La phrase d'accroche doit être une chaîne de caractère.";
        }
    }

}