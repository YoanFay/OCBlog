<?php

namespace App\Src\Entity;

use App\Src\Controller\Session;

class Comment
{

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
    private $created_at;

    /**
     * @var
     */
    private $validated_at;

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
    private $post_id;

    /**
     * @var
     */
    private $user_id;

    /**
     * @param bool     $init   parameter
     * @param int|null $idPost parameter
     */
    public function __construct(bool $init = false, int $idPost = null)
    {
        if ($init == "default") {
            $this->default($idPost);
        }
    }

    /**
     * @param int $id parameter
     * @return void
     */
    public function default(int $id)
    {
        $session = new Session();
        $this->created_at = date_format(new \DateTime(), 'Y-m-d H:i:s');
        $this->updated_at = null;
        $this->deleted_at = null;
        $this->post_id = $id;
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
     * @param mixed $created_at parameter
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
     * @param mixed $validated_at parameter
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
     * @param mixed $updated_at parameter
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
     * @param mixed $deleted_at parameter
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
     * @param int $post_id parameter
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
     * @param int $user_id parameter
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

}