<?php

namespace App\Src\Validator;

use App\Src\Entity\comment;
use App\Src\Repository\CategoryRepository;
use App\Src\Repository\UserRepository;

class CommentValidator extends Validator
{

    /**
     * @var Comment
     */
    private $comment;

    /**
     * @var array
     */
    private $error;


    /**
     * @param Comment $comment parameter
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
        $this->error = [];
    }

    /**
     * @return array|bool
     */
    public function validate()
    {
        $this->comment($this->comment->getContent());

        if ($this->error === []) {
            return true;
        }

        return $this->error;
    }

    /**
     * @param string $parameter parameter
     *
     * @return void
     */
    public function comment(string $parameter)
    {
        if ($this->validateIsNotEmpty($parameter) !== true) {
            $this->error['content'][] = "Le commentaire ne peut pas être vide.";
        }
        if ($this->validateIsString($parameter) !== true) {
            $this->error['content'][] = "Le commentaire doit être une chaîne de caractère.";
        }
    }

}
