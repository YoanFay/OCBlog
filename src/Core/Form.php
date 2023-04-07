<?php

namespace App\Src\Core;

class Form extends FormField
{


    /**
     * @return string
     */
    public function create(): string
    {
        //TODO: Voir pour mettre start et end avec
        return $this->formCode;

    }//end create()


    /**
     * @param string $method     parameter
     * @param string $action     parameter
     * @param array  $attributes parameter
     *
     * @return $this
     */
    public function startForm(string $method = 'post', string $action = '#', array $attributes = []): self
    {
        $this->formCode .= "<form action='$action' method='$method'";

        $this->formCode .= $attributes !== [] ?
            $this->addAttribute($attributes).'>' :
            '>';

        return $this;

    }//end startForm()

    /**
     * @return $this
     */
    public function endForm(): self
    {
        $this->formCode .= '</form>';
        return $this;
    }

    /**
     * @param array $errors parameter
     *
     * @return $this
     */
    public function addError(array $errors = []): self
    {
        foreach ($errors as $error) {
            $this->formCode .= "<p class='d-flex align-items-center text-danger'><span class='material-symbols-outlined me-2'>warning</span>$error</p>";
        }

        return $this;
    }

    /**
     * @param string $name  parameter
     * @param string $value parameter
     *
     * @return $this
     */
    public function addHidden(string $name, string $value): self
    {
        $this->formCode .= "<input type='hidden'  name='$name' value='$value' />";

        return $this;
    }

    /**
     * @param string $path parameter
     *
     * @return $this
     */
    public function addReturn(string $path): self
    {
        $this->formCode .= "<a href='$path' class='btn btn-primary'>Retour</a>";

        return $this;
    }
}
