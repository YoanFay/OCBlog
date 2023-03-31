<?php

namespace App\Src\Entity;

class Role
{

    /**
     * @return string
     */
    private $id;

    /**
     * @return string
     */
    private $name;

    /**
     * @return string
     */
    private $code;

    /**
     * @return string
     */
    private $level;

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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name parameter
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code parameter
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @param int $level parameter
     */
    public function setLevel(int $level): void
    {
        $this->level = $level;
    }


}