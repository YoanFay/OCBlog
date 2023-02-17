<?php

namespace App\Src\Validator;

use App\Src\Entity\File;

class FileValidator
{

    private const image_ext = ['jpeg', 'jpg', 'png'];
    private const pdf_ext = ['pdf'];
    private const image_size = 2097152;

    public function __construct($file)
    {
        $this->file = $file;
        $this->error = [];
    }

    /*public function validate($check_extensions, $max_size) {
    }*/

    public function validateImage(){

        $extension = pathinfo($this->file->getName(), PATHINFO_EXTENSION);
        if (!in_array($extension, self::image_ext))
        {
            $this->error['image'][] = "Le fichier doit être dans l'un des formats suivant : .jpeg, .jpg ou .png";
        }

        if ($this->file->getSize() > self::image_size) {
            $this->error['image'][] = "Le fichier doit faire moins de 2MB";
        }

        if ($this->error === []){
            return true;
        }

        return $this->error;
    }

    public function validatePdf(){

        $extension = pathinfo($this->file->getName(), PATHINFO_EXTENSION);
        if (!in_array($extension, self::pdf_ext))
        {
            $this->error['image'][] = "Le fichier doit être dans le format suivant : .pdf";
        }

        /*if ($this->file->getSize() > self::image_size) {
            $this->error['image'][] = "Le fichier doit faire moins de 2MB";
        }*/

        if ($this->error === []){
            return true;
        }

        return $this->error;
    }

}