<?php

namespace App\Src\Entity;

use App\Src\Controller\Session;

class Post{

    private $id;
    private $content;
    private $image;
    private $created_at;
    private $published_at;
    private $updated_at;
    private $deleted_at;
    private $excerpt;
    private $category_id;
    private $userid;

    public function __construct(){
        $this->image = null;
        $this->createdAt = date_format(new \DateTime(), 'Y-m-d H:i:s');
        $this->publishedAt = date_format(new \DateTime(), 'Y-m-d H:i:s');
        $this->updatedAt = null;
        $this->deletedAt = null;
        $this->userId = Session::getAuth('user_id');
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
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
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
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
     * @param mixed $createdAt
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
     * @param mixed $publishedAt
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
     * @param mixed $updatedAt
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
     * @param mixed $deletedAt
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
     * @param string $excerpt
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
     * @param int $categoryId
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
     * @param int $userId
     */
    public function setUser_id(int $userId): void
    {
        $this->userId = $userId;
    }

}