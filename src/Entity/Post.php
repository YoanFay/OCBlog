<?php

namespace App\Src\Entity;

use App\Src\Controller\Session;

class Post
{

    private const EXCERPT_SIZE = 70;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $image;

    /**
     * @var mixed
     */
    private $created_at;

    /**
     * @var mixed
     */
    private $published_at;

    /**
     * @var mixed
     */
    private $updated_at;

    /**
     * @var mixed
     */
    private $deleted_at;

    /**
     * @var string
     */
    private $excerpt;

    /**
     * @var integer
     */
    private $category_id;

    /**
     * @var integer
     */
    private $user_id;


    /**
     * @param bool $init parameter
     */
    public function __construct(bool $init = false)
    {
        if ($init === "default") {
            $this->default();
        }

    }//end __construct()


    /**
     * @return void
     */
    public function default()
    {
        $session = new Session();
        $this->image = null;
        $this->created_at = date_format(new \DateTime(), 'Y-m-d H:i:s');
        $this->updated_at = null;
        $this->deleted_at = null;
        $this->user_id = $session->getAuth('user_id');
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id parameter
     *
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content parameter
     *
     * @return void
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
        $this->setExcerpt(substr($content, 0, self::EXCERPT_SIZE));
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image parameter
     *
     * @return void
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $createdAt parameter
     *
     * @return void
     */
    public function setCreatedAt($createdAt): void
    {
        $this->created_at = $createdAt;
    }

    /**
     * @return mixed|null
     */
    public function getPublishedAt()
    {
        return $this->published_at;
    }

    /**
     * @param mixed|null $publishedAt parameter
     *
     * @return void
     */
    public function setPublishedAt($publishedAt): void
    {
        $this->published_at = $publishedAt;
    }

    /**
     * @return mixed|null
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed|null $updatedAt parameter
     *
     * @return void
     */
    public function setUpdatedAt($updatedAt): void
    {
        $this->updated_at = $updatedAt;
    }

    /**
     * @return mixed|null
     */
    public function getDeletedAt()
    {
        return $this->deleted_at;
    }

    /**
     * @param mixed|null $deletedAt parameter
     *
     * @return void
     */
    public function setDeletedAt($deletedAt): void
    {
        $this->deleted_at = $deletedAt;
    }

    /**
     * @return string
     */
    public function getExcerpt(): string
    {
        return $this->excerpt;
    }

    /**
     * @param string $excerpt parameter
     *
     * @return void
     */
    public function setExcerpt(string $excerpt): void
    {
        $this->excerpt = $excerpt;
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    /**
     * @param int $categoryId parameter
     *
     * @return void
     */
    public function setCategoryId(int $categoryId): void
    {
        $this->category_id = $categoryId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $userId parameter
     *
     * @return void
     */
    public function setUserId(int $userId): void
    {
        $this->user_id = $userId;
    }

}
