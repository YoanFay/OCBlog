<?php

namespace App\Src\Core;

class Form{

    private $formCode = '';

    public function create(){
        return $this->formCode;
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

    public function addTextArea(string $nom, string $text = "", array $attributes = []):self
    {
        $this->formCode .= "<textarea name='$nom'";

        $this->formCode .= $attributes?$this->addAttribute($attributes).'>' : '>';

        $this->formCode .= "$text</textarea>";

        return $this;
    }

    public function addSelect(string $nom, array $options, array $attributes = []):self
    {
        $this->formCode .= "<select name='$nom'";

        $this->formCode .= $attributes?$this->addAttribute($attributes).'>' : '>';

        foreach ($options as $key => $option) {
            $this->formCode .= "<option value='$key'>$option</option>";
        }

        $this->formCode .= "</select>";

        return $this;
    }

    public function addError(array $errors = []):self
    {
        foreach ($errors as $key => $error) {
            $this->formCode .= "<p class='d-flex align-items-center text-danger'><span class='material-symbols-outlined me-2'>warning</span>$error</p>";
        }

        return $this;
    }

    public function addText(string $text):self
    {
        $this->formCode .= "<p class='d-flex align-items-center'>$text</p>";

        return $this;
    }

    public function addHidden(string $name, string $value){
        $this->formCode .= "<input type='hidden'  name='$name' value='$value' />";

        return $this;
    }
}