<?php

namespace App\Src\Validator;

use App\Src\Entity\Config;

class ConfigValidator extends Validator
{

    /**
     * @var Config
     */
    private $config;

    /**
     * @var array
     */
    private $error;


    /**
     * @param Config $config parameter
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->error = [];
    }

    /**
     * @return array|bool
     */
    public function validate()
    {
        $this->title($this->config->getTitle());
        $this->catchPhrase($this->config->getCatchPhrase());

        if ($this->error === []) {
            return true;
        }

        return $this->error;
    }

    /**
     * @param string $parameter parameter
     * @return void
     */
    public function title(string $parameter)
    {
        if ($this->validateIsNotEmpty($parameter) !== true) {
            $this->error['content'][] = "Le titre ne peut pas être vide.";
        }
        if ($this->validateIsString($parameter) !== true) {
            $this->error['content'][] = "Le titre doit être une chaîne de caractère.";
        }
    }

    /**
     * @param string $parameter parameter
     * @return void
     */
    public function catchPhrase(string $parameter)
    {
        if ($this->validateIsNotEmpty($parameter) !== true) {
            $this->error['catchPhrase'][] = "La phrase d'accroche ne peut pas être vide.";
        }
        if ($this->validateIsString($parameter) !== true) {
            $this->error['catchPhrase'][] = "La phrase d'accroche doit être une chaîne de caractère.";
        }
    }

}
