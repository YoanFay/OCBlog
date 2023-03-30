<?php

namespace App\Src\Entity;

use App\Src\Controller\Session;

class Post
{

    private const excerpt_size = 70;

    /**
     * @var
     */
    private $id;

    /**
     * @var
     */
    private $content;

    /**
     * @var
     */
    private $image;
    /**
     * @var
     */
    private $created_at;

    /**
     * @var
     */
    private $published_at;

    /**
     * @var
     */
    private $updated_at;

    /**
     * @var
     */
    private $deleted_at;

    /**
     * @var
     */
    private $excerpt;

    /**
     * @var
     */
    private $category_id;

    /**
     * @var
     */
    private $user_id;

    /**
     * @param bool $init
     */
    public function __construct(bool $init = false)
    {
        if ($init == "default") {
            $this->default();
        }
    }
    //end __construct

    /**
     * @return void
     */
    public function default()
    {
        $this->image = null;
        $this->created_at = date_format(new \DateTime(), 'Y-m-d H:i:s');
        $this->updated_at = null;
        $this->deleted_at = null;
        $this->user_id = Session::getAuth('user_id');
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id    parameter
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
     * @param string $content    parameter
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
        $this->setExcerpt(substr($content, 0, self::excerpt_size));
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image    parameter
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
     * @param mixed $createdAt    parameter
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
     * @param mixed|null $publishedAt    parameter
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
     * @param mixed|null $updatedAt    parameter
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
     * @param mixed|null $deletedAt    parameter
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
     * @param string $excerpt    parameter
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
     * @param int $categoryId    parameter
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
     * @param int $userId    parameter
     */
    public function setUserId(int $userId): void
    {
        $this->user_id = $userId;
    }

}