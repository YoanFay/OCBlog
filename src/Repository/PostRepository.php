<?php

namespace App\Src\Repository;

use App\Src\Core\Bdd;
use App\Src\Entity\Category;
use App\Src\Entity\Post;
use App\Src\Validator\PostValidator;
use Exception;

class PostRepository
{

    private $bdd;
    private $class = Post::class;

    public function __construct()
    {
        $this->bdd = new BDD();
    }

    public function findOneBy(array $parameters = [])
    {

        $req = 'SELECT * FROM post';

        $row = 0;
        $length = count($parameters);

        if ($parameters !== []) {
            $req .= ' WHERE ';

            foreach ($parameters as $key => $parameter) {
                $req .= "$key = '$parameter'";

                $row++;

                if ($row !== $length) {
                    $req .= " AND ";
                }
            }
        }

        if ($post = $this->bdd->select($req, $this->class)) {
            return $post[0];
        } else {
            return NULL;
        }

    }

    public function findAll()
    {

        $req = 'SELECT * FROM post';

        if ($posts = $this->bdd->select($req, $this->class)) {
            return $posts;
        } else {
            return NULL;
        }

    }

    public function insert(Post $post)
    {

        $req = 'INSERT INTO post VALUES(NULL, :content, :image, :createdAt, :publishedAt, :updatedAt, :deletedAt, :excerpt, :category, :user)';

        $postInfo = [
            'content' => $post->getContent(),
            'image' => $post->getImage(),
            'createdAt' => $post->getCreatedAt(),
            'publishedAt' => $post->getPublishedAt(),
            'updatedAt' => $post->getUpdatedAt(),
            'deletedAt' => $post->getDeletedAt(),
            'excerpt' => $post->getExcerpt(),
            'category' => $post->getCategoryId(),
            'user' => $post->getUserId(),
        ];

        $this->bdd->query($req, $postInfo);
    }

}