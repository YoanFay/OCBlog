<?php

namespace App\Src\Validator;

use App\Src\Entity\File;

class FileValidator
{

    private const image_ext = ['jpeg', 'jpg', 'png'];
    private const pdf_ext = ['pdf'];
    private const image_size = 2097152;

    /**
     * @var array
     */
    private $error;

    /**
     * @var File
     */
    private $file;


    /**
     * @param File $file
     */
    public function __construct(File $file)
    {
        $this->file = $file;
        $this->error = [];
    }

    /**
     * @return array|bool
     */
    public function validateImage()
    {

        if ($this->file->getSize() > 0) {
            $extension = pathinfo($this->file->getName(), PATHINFO_EXTENSION);
            if (in_array($extension, self::image_ext) === FALSE) {
                $this->error['image'][] = "Le fichier doit être dans l'un des formats suivant : .jpeg, .jpg ou .png";
            }

            if ($this->file->getSize() > self::image_size) {
                $this->error['image'][] = "Le fichier doit faire moins de 2MB";
            }
        }

        if ($this->error === []) {
            return true;
        }

        return $this->error;
    }

    /**
     * @return array|bool
     */
    public function validatePdf()
    {

        $extension = pathinfo($this->file->getName(), PATHINFO_EXTENSION);
        if (in_array($extension, self::pdf_ext) === FALSE) {
            $this->error['image'][] = "Le fichier doit être dans le format suivant : .pdf";
        }

        if ($this->error === []) {
            return true;
        }

        return $this->error;
    }

}
