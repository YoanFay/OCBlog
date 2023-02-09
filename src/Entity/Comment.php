<?php

namespace App\Src\Entity;

use App\Src\Controller\Session;

class Comment{

    private $id;
    private $content;
    private $created_at;
    private $validated_at;
    private $updated_at;
    private $deleted_at;
    private $post_id;
    private $user_id;

    public function __construct($init = false, $idPost = null){
        if($init == "default"){
            $this->default($idPost);
        }
    }

    public function default($idPost){
        $this->created_at = date_format(new \DateTime(), 'Y-m-d H:i:s');
        $this->updated_at = null;
        $this->deleted_at = null;
        $this->post_id = $idPost;
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
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getValidatedAt()
    {
        return $this->validated_at;
    }

    /**
     * @param mixed $validated_at
     */
    public function setValidatedAt($validated_at): void
    {
        $this->validated_at = $validated_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return mixed
     */
    public function getDeletedAt()
    {
        return $this->deleted_at;
    }

    /**
     * @param mixed $deleted_at
     */
    public function setDeletedAt($deleted_at): void
    {
        $this->deleted_at = $deleted_at;
    }

    /**
     * @return int
     */
    public function getPostId(): int
    {
        return $this->post_id;
    }

    /**
     * @param int $post_id
     */
    public function setPostId(int $post_id): void
    {
        $this->post_id = $post_id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

}