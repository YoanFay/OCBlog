<?php

namespace App\Src\Validator;

use App\Src\Entity\Post;
use App\Src\Repository\CategoryRepository;
use App\Src\Repository\UserRepository;

class PostValidator extends Validator
{

    private $post;

    public function __construct($post)
    {
        $this->post = $post;
        $this->error = [];
    }

    public function validate()
    {
        $this->content($this->post->getContent());
        $this->category($this->post->getCategoryId());

        if ($this->error === []){
            return true;
        }

        return $this->error;
    }

    public function content($parameter)
    {
        if ($this->validateIsNotEmpty($parameter) !== true){
            $this->error['content'][] = "L'article ne peut pas être vide.";
        }
        if ($this->validateIsString($parameter) !== true){
            $this->error['content'][] = "L'article doit être une chaîne de caractère.";
        }
    }

    public function category($parameter)
    {

        $categoryRepository = new CategoryRepository();

        $category = $categoryRepository->find($parameter);

        if ($category === null) {
            $this->error['category'][] = "La catégorie sélectionnée n'existe pas.";
        }
    }

}