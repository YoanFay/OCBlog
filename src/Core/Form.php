<?php

namespace App\Src\Core;

class Form{

    private $formCode = '';

    public function create(){
        return $this->formCode;
    }

    public function validate(array $form, array $champs){

        foreach ($champs as $champ) {

            if (!isset($form[$champ]) || empty($form[$champ])){
                return false;
            }

        }

        return true;
    }

    private function addAttribute(array $attributes): string
    {
        $str = '';

        $courts = ['checked', 'disabled', 'readonly', 'multiple', 'required', 'autofocus'];

        foreach ($attributes as $attribute => $valeur) {
            if (in_array($attribute, $courts) && $valeur === true){
                $str .= " $attribute";
            }else{
                $str .= " $attribute='$valeur'";
            }
        }

        return $str;
    }

    public function startForm(string $method = 'post', string $action = '#', array $attributes = []): self
    {
        $this->formCode .= "<form action='$action' method='$method'";

        $this->formCode .= $attributes?$this->addAttribute($attributes).'>' : '>';

        return $this;
    }

    public function endForm(): self
    {
        $this->formCode .= '</form>';
        return $this;
    }

    public function addInput(string $type, string $name, array $attributes = []):self
    {
        $this->formCode .= "<input type='$type' name='$name'";

        $this->formCode .= $attributes?$this->addAttribute($attributes).'>' : '>';

        return $this;
    }

    public function addLabelFor(string $for, string $text, array $attributes = []):self
    {
        $this->formCode .= "<label for='$for'";

        $this->formCode .= $attributes?$this->addAttribute($attributes) : '';

        $this->formCode .= ">$text</label>";

        return $this;
    }
}