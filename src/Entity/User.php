<?php

namespace App\Src\Entity;

class User
{

    /**
     * @return string
     */
    private $id;

    /**
     * @return string
     */
    private $lastname;

    /**
     * @return string
     */
    private $firstname;

    /**
     * @return string
     */
    private $login;

    /**
     * @return string
     */
    private $password;

    /**
     * @return string
     */
    private $created_at;

    /**
     * @return string
     */
    private $avatar;

    /**
     * @return string
     */
    private $role_id;

    /**
     *
     */
    public function __construct()
    {
        $this->created_at = new \DateTime();
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
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname parameter
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname parameter
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login parameter
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password parameter
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at parameter
     * @return void
     */
    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return int
     */
    public function getRoleId(): ?int
    {
        return $this->role_id;
    }

    /**
     * @param int $role_id parameter
     */
    public function setRoleId(int $role_id): void
    {
        $this->role_id = $role_id;
    }

    /**
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar parameter
     */
    public function setAvatar(string $avatar): void
    {
        $this->avatar = $avatar;
    }
}