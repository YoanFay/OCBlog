<?php

namespace App\Src\Core;

class FormField
{

    
    /**
     * @var string
     */
    protected $formCode = '';

    /**
     * @param string $nom        parameter
     * @param string $text       parameter
     * @param array  $attributes parameter
     *
     * @return $this
     */
    public function addTextArea(string $nom, string $text = "", array $attributes = []): self
    {
        $this->formCode .= "<textarea name='$nom'";

        $this->formCode .= $attributes !== [] ?
            $this->addAttribute($attributes).'>' :
            '>';

        $this->formCode .= "$text</textarea>";

        return $this;
    }

    /**
     * @param array $attributes parameter
     *
     * @return string
     */
    protected function addAttribute(array $attributes): string
    {
        $str = '';

        $courts = ['checked', 'disabled', 'readonly', 'multiple', 'required', 'autofocus'];

        foreach ($attributes as $attribute => $valeur) {
            if (in_array($attribute, $courts) === TRUE && $valeur === true) {
                $str .= " $attribute";
            } else {
                $str .= " $attribute='$valeur'";
            }
        }

        return $str;

    }

    /**
     * @param string $nom        parameter
     * @param array  $options    parameter
     * @param array  $attributes parameter
     *
     * @return $this
     */
    public function addSelect(string $nom, array $options, array $attributes = []): self
    {
        $this->formCode .= "<select name='$nom'";

        $this->formCode .= $attributes !== [] ?
            $this->addAttribute($attributes).'>' :
            '>';

        foreach ($options as $key => $option) {
            $this->formCode .= "<option value='$key'>$option</option>";
        }

        $this->formCode .= "</select>";

        return $this;
    }//end addAttribute()

    /**
     * @param string $name parameter
     * @param string $text parameter
     *
     * @return $this
     */
    public function addCheckbox(string $name, string $text): self
    {
        $this->formCode .= "<div class='d-flex flex-row justify-content-start mb-2'><input type='checkbox' name='$name' id='$name' class='me-2' /><label for='$name'>$text</label></div>";

        return $this;
    }

    /**
     * @param string $type parameter
     * @param string $name parameter
     *
     * @return $this
     */
    public function addImage(string $type, string $name): self
    {
        $this->formCode .= "<img class='ms-3 mb-2 row' src='/img/$type/$name' width='100px'>";

        return $this;
    }

    /**
     * @param string $type       parameter
     * @param string $name       parameter
     * @param array  $attributes parameter
     *
     * @return $this
     */
    protected function addInput(string $type, string $name, array $attributes = []): self
    {
        $this->formCode .= "<input type='$type' name='$name'";

        $this->formCode .= $attributes !== [] ?
            $this->addAttribute($attributes).'>' :
            '>';

        return $this;
    }

    /**
     * @param string $for        parameter
     * @param string $text       parameter
     * @param array  $attributes parameter
     *
     * @return $this
     */
    protected function addLabelFor(string $for, string $text, array $attributes = []): self
    {
        $this->formCode .= "<label for='$for'";

        $this->formCode .= $attributes !== [] ?
            $this->addAttribute($attributes) :
            '';

        $this->formCode .= ">$text</label>";

        return $this;
    }

}
