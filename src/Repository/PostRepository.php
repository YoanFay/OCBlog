<?php

namespace App\Src\Repository;

use App\Src\Core\Bdd;
use App\Src\Entity\Post;
use Exception;

class PostRepository extends PostRepositoryUpdate
{


    /**
     * Constructeur
     */
    public function __construct()
    {

        $this->bdd = new BDD();

    }//end __construct()


    /**
     * @param array $parameters parameter
     *
     * @return array|null
     */
    public function findBy(array $parameters = []): ?array
    {

        $req = 'SELECT * FROM post';

        $row = 0;
        $length = count($parameters);

        if ($parameters !== []) {
            $req .= ' WHERE ';

            foreach ($parameters as $key => $parameter) {
                switch ($parameter) {
                case "is not null":
                    $req .= "$key IS NOT NULL";
                    break;
                case "is null":
                    $req .= "$key IS NULL";
                    break;
                default:
                    $req .= "$key = '$parameter'";
                }

                $row++;

                if ($row !== $length) {
                    $req .= " AND ";
                }
            }
        }

        if ($posts = $this->bdd->select($req, $this->class)) {
            return $posts;
        }

        return NULL;

    }//end findBy()


    /**
     * @return array|null
     */
    public function findAll(): ?array
    {

        $req = 'SELECT * FROM post ORDER BY created_at DESC ';

        if ($posts = $this->bdd->select($req, $this->class)) {
            return $posts;
        }

        return NULL;

    }//end findAll()


    /**
     * @param int  $category_id parameter
     * @param bool $null        parameter
     *
     * @return array|null
     */
    public function findPublishedPostByCategory(int $category_id, bool $null = false): ?array
    {

        $req = "SELECT p.*, u.avatar, u.firstname, u.lastname, c.name FROM post p INNER JOIN user u ON p.user_id = u.id INNER JOIN category c on p.category_id = c.id WHERE published_at IS NOT NULL AND category_id = :category_id AND deleted_at IS NULL ORDER BY p.created_at DESC";

        if ($null === true) {
            $req = "SELECT p.*, u.avatar, u.firstname, u.lastname, c.name AS 'post_id' FROM post p INNER JOIN user u ON p.user_id = u.id INNER JOIN category c on p.category_id = c.id WHERE published_at IS NULL AND category_id = :category_id AND deleted_at IS NULL ORDER BY p.created_at ASC";
        }

        if ($posts = $this->bdd->select($req, $this->class, ['category_id' => $category_id])) {
            return $posts;
        }

        return NULL;

    }


    /**
     * @return array|null
     */
    public function findLastPublishedPost(): ?array
    {

        $req = "SELECT p.*, u.avatar, u.firstname, u.lastname, c.name FROM post p INNER JOIN user u ON p.user_id = u.id INNER JOIN category c on p.category_id = c.id WHERE p.published_at IS NOT NULL AND p.deleted_at IS NULL ORDER BY p.created_at DESC LIMIT 3";

        if ($posts = $this->bdd->select($req, $this->class)) {
            return $posts;
        }

        return NULL;

    }


    /**
     * @param bool $null parameter
     *
     * @return array|null
     */
    public function findPublishedPost(bool $null = false): ?array
    {

        $req = "SELECT p.*, u.avatar, u.firstname, u.lastname, c.name FROM post p INNER JOIN user u ON p.user_id = u.id INNER JOIN category c on p.category_id = c.id WHERE published_at IS NOT NULL AND deleted_at IS NULL ORDER BY p.created_at DESC";

        if ($null === true) {
            $req = "SELECT p.*, u.avatar, u.firstname, u.lastname, c.name FROM post p INNER JOIN user u ON p.user_id = u.id INNER JOIN category c on p.category_id = c.id WHERE published_at IS NULL AND deleted_at IS NULL ORDER BY p.created_at ASC";
        }

        if ($posts = $this->bdd->select($req, $this->class)) {
            return $posts;
        }

        return NULL;

    }


    /**
     * @return array|null
     */
    public function findNotPublishedCommentPost(): ?array
    {

        $req = "SELECT p.id, p.content, p.image, p.created_at, p.excerpt, COUNT(p.id) AS 'nbr', u.avatar as 'avatar', u.firstname, u.lastname, c2.name FROM `post` as p INNER JOIN comment as c ON p.id = c.post_id INNER JOIN `user` as u ON p.user_id = u.id INNER JOIN  category c2 on p.category_id = c2.id WHERE c.validated_at IS NULL AND  c.deleted_at IS NULL GROUP BY p.id ORDER BY c.created_at";

        if ($posts = $this->bdd->select($req, $this->class)) {
            return $posts;
        }

        return NULL;

    }


    /**
     * @param int $category_id parameter
     *
     * @return array|null
     */
    public function findNotPublishedCommentPostByCategory(int $category_id): ?array
    {

        $req = "SELECT p.id, p.content, p.image, p.created_at, p.excerpt, COUNT(p.id) AS 'nbr', u.avatar as 'avatar', u.firstname, u.lastname, c2.name FROM `post` as p INNER JOIN comment as c ON p.id = c.post_id INNER JOIN `user` as u ON p.user_id = u.id INNER JOIN category c2 on p.category_id = c2.id WHERE c.validated_at IS NULL AND  c.deleted_at IS NULL AND p.category_id = :category_id GROUP BY p.id";

        if ($posts = $this->bdd->select($req, $this->class, ['category_id' => $category_id])) {
            return $posts;
        }

        return NULL;
    }


    /**
     * @param int $idPost parameter
     *
     * @return mixed|null
     */
    public function find(int $idPost)
    {

        $req = "SELECT p.*, user.avatar, user.firstname, user.lastname, c.name FROM post as p INNER JOIN user ON p.user_id = user.id INNER JOIN category c on p.category_id = c.id WHERE p.id = ".$idPost;

        if ($post = $this->bdd->select($req, $this->class)) {
            return $post[0];
        }

        return NULL;

    }


}
