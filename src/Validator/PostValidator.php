<?php

namespace App\Src\Validator;

use App\Src\Entity\Post;
use App\Src\Repository\CategoryRepository;
use App\Src\Repository\UserRepository;

class PostValidator extends Validator
{

    /**
     * @var Post
     */
    private $post;

    /**
     * @var array
     */
    private $error;


    /**
     * @param Post $post parameter
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
        $this->error = [];
    }

    /**
     * @return array|bool
     */
    public function validate()
    {
        $this->content($this->post->getContent());
        $this->category($this->post->getCategoryId());

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
    public function content(string $parameter)
    {
        if ($this->validateIsNotEmpty($parameter) !== true) {
            $this->error['content'][] = "L'article ne peut pas être vide.";
        }
        if ($this->validateIsString($parameter) !== true) {
            $this->error['content'][] = "L'article doit être une chaîne de caractère.";
        }
    }

    /**
     * @param int $parameter parameter
     *
     * @return void
     */
    public function category(int $parameter)
    {

        $categoryRepository = new CategoryRepository();

        $category = $categoryRepository->find($parameter);

        if ($category === null) {
            $this->error['category'][] = "La catégorie sélectionnée n'existe pas.";
        }
    }

}
