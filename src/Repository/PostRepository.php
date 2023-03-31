<?php

namespace App\Src\Repository;

use App\Src\Core\Bdd;
use App\Src\Entity\Category;
use App\Src\Entity\Post;
use App\Src\Validator\PostValidator;
use Exception;

class PostRepository
{

    /**
     * @var Bdd
     */
    private $bdd;
    /**
     * @var string
     */
    private $class = Post::class;


    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->bdd = new BDD();

    }
    //end __construct()


    /**
     * @param array $parameters parameter
     * @return mixed|null
     */
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
        }

        return NULL;
    }


    /**
     * @param array $parameters parameter
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
    }

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
    }

    /**
     * @param Category $category_id parameter
     * @return array|null
     */
    public function findPublishedPostByCategory(Category $category_id)
    {

        $req = "SELECT p.*, u.avatar, u.firstname, u.lastname FROM post p INNER JOIN user u ON p.user_id = u.id WHERE published_at IS NOT NULL AND category_id = :category_id AND deleted_at IS NULL ORDER BY p.created_at DESC";

        if ($posts = $this->bdd->select($req, $this->class, ['category_id' => $category_id])) {
            return $posts;
        }

        return NULL;
    }

    /**
     * @param Category $category_id parameter
     * @return array|null
     */
    public function findNotPublishedPostByCategory(Category $category_id): ?array
    {

        $req = "SELECT p.*, u.avatar, u.firstname, u.lastname AS 'post_id' FROM post p INNER JOIN user u ON p.user_id = u.id WHERE published_at IS NULL AND category_id = :category_id AND deleted_at IS NULL ORDER BY p.created_at ASC";

        if ($posts = $this->bdd->select($req, $this->class, ['category_id' => $category_id])) {
            return $posts;
        }

        return NULL;
    }

    /**
     * @return array|null
     */
    public function findLastPost(): ?array
    {

        $req = 'SELECT * FROM post ORDER BY created_at DESC LIMIT 3';

        if ($posts = $this->bdd->select($req, $this->class)) {
            return $posts;
        }

        return NULL;

    }

    /**
     * @return array|null
     */
    public function findLastPublishedPost(): ?array
    {

        $req = "SELECT p.*, u.avatar, u.firstname, u.lastname FROM post p INNER JOIN user u ON p.user_id = u.id WHERE p.published_at IS NOT NULL AND p.deleted_at IS NULL ORDER BY p.created_at DESC LIMIT 3";

        if ($posts = $this->bdd->select($req, $this->class)) {
            return $posts;
        }

        return NULL;

    }

    /**
     * @return array|null
     */
    public function findNotPublishedPost(): ?array
    {

        $req = "SELECT p.*, u.avatar, u.firstname, u.lastname FROM post p INNER JOIN user u ON p.user_id = u.id WHERE published_at IS NULL AND deleted_at IS NULL ORDER BY p.created_at ASC";

        if ($posts = $this->bdd->select($req, $this->class)) {
            return $posts;
        }

        return NULL;

    }

    /**
     * @return array|null
     */
    public function findPublishedPost(): ?array
    {

        $req = "SELECT p.*, u.avatar, u.firstname, u.lastname FROM post p INNER JOIN user u ON p.user_id = u.id WHERE published_at IS NOT NULL AND deleted_at IS NULL ORDER BY p.created_at DESC";

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

        $req = "SELECT p.id, p.content, p.image, p.created_at, COUNT(p.id) AS 'nbr', u.avatar as 'avatar' FROM `post` as p INNER JOIN comment as c ON p.id = c.post_id INNER JOIN `user` as u ON p.user_id = u.id WHERE c.validated_at IS NULL AND  c.deleted_at IS NULL GROUP BY p.id ORDER BY c.created_at";

        if ($posts = $this->bdd->select($req, $this->class)) {
            return $posts;
        }

        return NULL;

    }

    /**
     * @param Category $category_id parameter
     * @return array|null
     */
    public function findNotPublishedCommentPostByCategory(Category $category_id)
    {

        $req = "SELECT p.id, p.content, p.image, p.created_at, COUNT(p.id) AS 'nbr', u.avatar as 'avatar' FROM `post` as p INNER JOIN comment as c ON p.id = c.post_id INNER JOIN `user` as u ON p.user_id = u.id WHERE c.validated_at IS NULL AND  c.deleted_at IS NULL AND p.category_id = :category_id GROUP BY p.id";

        if ($posts = $this->bdd->select($req, $this->class, ['category_id' => $category_id])) {
            return $posts;
        }

        return NULL;
    }

    /**
     * @param Post $post parameter
     * @return void
     */
    public function insert(Post $post)
    {

        $req = 'INSERT INTO post VALUES(NULL, :content, :image, :createdAt, :publishedAt, :updatedAt, :deletedAt, :excerpt, :category, :user)';

        $postInfo =
            [
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

    /**
     * @param int $idPost parameter
     * @return mixed|null
     */
    public function find(int $idPost)
    {

        $req = "SELECT p.*, user.avatar, user.firstname, user.lastname FROM post as p INNER JOIN user ON p.user_id = user.id WHERE p.id = ".$idPost;

        if ($post = $this->bdd->select($req, $this->class)) {
            return $post[0];
        }

        return NULL;

    }

    /**
     * @param int $idPost parameter
     * @return Exception|void
     */
    public function delete(int $idPost)
    {
        $req = "DELETE FROM post WHERE id = ".$idPost;

        try {
            $this->bdd->query($req);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function softDelete(int $idPost)
    {
        $req = 'UPDATE post SET deleted_at = "'.date_format(new \DateTime(), 'Y-m-d H:i:s').'" WHERE id = '.$idPost;

        try {
            $this->bdd->query($req);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function update(Post $post)
    {

        $req = 'UPDATE post SET content = :content, image = :image, published_at = :publishedAt, updated_at = :updatedAt, excerpt = :excerpt, category_id = :category WHERE id = :id';

        $postInfo =
            [
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
        } catch (Exception $e) {
            return $e;
        }
    }

}
