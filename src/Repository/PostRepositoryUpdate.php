<?php

namespace App\Src\Repository;

use App\Src\Core\Bdd;
use App\Src\Entity\Post;
use Exception;

class PostRepositoryUpdate
{

    /**
     * @var Bdd
     */
    protected $bdd;

    /**
     * @var string
     */
    protected $class = Post::class;


    /**
     * @param Post $post parameter
     *
     * @return void
     */
    public function insert(Post $post)
    {

        $req = 'INSERT INTO post VALUES(NULL, :content, :image, :createdAt, :publishedAt, :updatedAt, :deletedAt, :excerpt, :category, :user)';

        $postInfo
            = [
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
     *
     * @return Exception|void
     */
    public function softDelete(int $idPost)
    {

        $req = 'UPDATE post SET deleted_at = "'.date_format(new \DateTime(), 'Y-m-d H:i:s').'" WHERE id = '.$idPost;

        try {
            $this->bdd->query($req);
        } catch (Exception $e) {
            return $e;
        }
    }


    /**
     * @param Post $post parameter
     *
     * @return bool
     */
    public function update(Post $post)
    {

        $req = 'UPDATE post SET content = :content, image = :image, published_at = :publishedAt, updated_at = :updatedAt, excerpt = :excerpt, category_id = :category WHERE id = :id';

        $postInfo
            = [
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

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}
