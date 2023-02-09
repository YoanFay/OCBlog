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

    public function findBy(array $parameters = [])
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

        if ($posts = $this->bdd->select($req, $this->class)) {
            return $posts;
        } else {
            return NULL;
        }

    }

    public function findAll()
    {

        $req = 'SELECT * FROM post ORDER BY created_at DESC ';

        if ($posts = $this->bdd->select($req, $this->class)) {
            return $posts;
        } else {
            return NULL;
        }

    }

    public function findPublishedPostByCategory($category_id){

        $req = 'SELECT * FROM post WHERE published_at IS NOT NULL AND category_id = :category_id AND deleted_at IS NULL ORDER BY created_at DESC';

        if ($posts = $this->bdd->select($req, $this->class, ['category_id' => $category_id])) {
            return $posts;
        } else {
            return NULL;
        }
    }

    public function findNotPublishedPostByCategory($category_id){

        $req = 'SELECT * FROM post WHERE published_at IS NULL AND category_id = :category_id AND deleted_at IS NULL ORDER BY created_at ASC';

        if ($posts = $this->bdd->select($req, $this->class, ['category_id' => $category_id])) {
            return $posts;
        } else {
            return NULL;
        }
    }

    public function findLastPost()
    {

        $req = 'SELECT * FROM post ORDER BY created_at DESC LIMIT 3';

        if ($posts = $this->bdd->select($req, $this->class)) {
            return $posts;
        } else {
            return NULL;
        }

    }

    public function findLastPublishedPost()
    {

        $req = 'SELECT * FROM post WHERE published_at IS NOT NULL AND deleted_at IS NULL ORDER BY created_at DESC LIMIT 3';

        if ($posts = $this->bdd->select($req, $this->class)) {
            return $posts;
        } else {
            return NULL;
        }

    }

    public function findNotPublishedPost()
    {

        $req = 'SELECT * FROM post WHERE published_at IS NULL AND deleted_at IS NULL ORDER BY created_at ASC';

        if ($posts = $this->bdd->select($req, $this->class)) {
            return $posts;
        } else {
            return NULL;
        }

    }

    public function findPublishedPost()
    {

        $req = 'SELECT * FROM post WHERE published_at IS NOT NULL AND deleted_at IS NULL ORDER BY created_at DESC';

        if ($posts = $this->bdd->select($req, $this->class)) {
            return $posts;
        } else {
            return NULL;
        }

    }

    public function findNotPublishedCommentPost()
    {

        $req = 'SELECT p.id, p.content, p.image, p.created_at, COUNT(p.id) AS "nbr" FROM `post` as p INNER JOIN comment as c ON p.id = c.post_id WHERE c.validated_at IS NULL AND  c.deleted_at IS NULL GROUP BY p.id ORDER BY c.created_at';

        if ($posts = $this->bdd->select($req, $this->class)) {
            return $posts;
        } else {
            return NULL;
        }

    }

    public function findNotPublishedCommentPostByCategory($category_id){

        $req = 'SELECT p.id, p.content, p.image, p.created_at, COUNT(p.id) AS "nbr" FROM `post` as p INNER JOIN comment as c ON p.id = c.post_id WHERE c.validated_at IS NULL AND  c.deleted_at IS NULL AND p.category_id = :category_id GROUP BY p.id';

        if ($posts = $this->bdd->select($req, $this->class, ['category_id' => $category_id])) {
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

    public function find(int $id){

        $req = "SELECT * FROM post WHERE id = ".$id;

        if($post = $this->bdd->select($req, $this->class)) {
            return $post[0];
        }else{
            return NULL;
        }
    }

    public function delete(int $id){
        $req = "DELETE FROM post WHERE id = ".$id;

        try {
            $this->bdd->query($req);
        }catch (Exception $e){
            return $e;
        }
    }

    public function softDelete(int $id){
        $req = 'UPDATE post SET deleted_at = "'.date_format(new \DateTime(), 'Y-m-d H:i:s').'" WHERE id = '.$id;

        try {
            $this->bdd->query($req);
        }catch (Exception $e){
            return $e;
        }
    }

    public function update(Post $post)
    {

        $req = 'UPDATE post SET content = :content, image = :image, published_at = :publishedAt, updated_at = :updatedAt, excerpt = :excerpt, category_id = :category WHERE id = :id';

        $postInfo = [
            'id' => $post->getId(),
            'content' => $post->getContent(),
            'image' => $post->getImage(),
            'publishedAt' => $post->getPublishedAt(),
            'updatedAt' => date_format(new \DateTime(), 'Y-m-d H:i:s'),
            'excerpt' => $post->getExcerpt(),
            'category' => $post->getCategoryId(),
        ];

        try {
            $this->bdd->query($req, $postInfo);
        }catch (Exception $e){
            return $e;
        }
    }

}