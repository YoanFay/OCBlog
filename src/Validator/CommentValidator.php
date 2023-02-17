<?php

namespace App\Src\Validator;

use App\Src\Entity\comment;
use App\Src\Repository\CategoryRepository;
use App\Src\Repository\UserRepository;

class CommentValidator extends Validator
{

    private $comment;

    public function __construct($comment)
    {
        $this->comment = $comment;
        $this->error = [];
    }

    public function validate()
    {
        $this->comment($this->comment->getContent());

        if ($this->error === []){
            return true;
        }

        return $this->error;
    }

    public function comment($parameter)
    {
        if ($this->validateIsNotEmpty($parameter) !== true){
            $this->error['content'][] = "Le commentaire ne peut pas être vide.";
        }
        if ($this->validateIsString($parameter) !== true){
            $this->error['content'][] = "Le commentaire doit être une chaîne de caractère.";
        }
    }

}