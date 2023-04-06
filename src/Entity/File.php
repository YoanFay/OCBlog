<?php

namespace App\Src\Entity;

class File
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $tmp_name;

    /**
     * @var string
     */
    private $error;

    /**
     * @var string
     */
    private $size;


    /**
     * @param mixed $file parameter
     */
    public function __construct($file)
    {
        $this->name = $file['name'];
        $this->type = $file['type'];
        $this->tmp_name = $file['tmp_name'];
        $this->error = $file['error'];
        $this->size = $file['size'];
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
     *
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type parameter
     *
     * @return void
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getTmpName(): string
    {
        return $this->tmp_name;
    }

    /**
     * @param string $tmp_name parameter
     *
     * @return void
     */
    public function setTmpName(string $tmp_name): void
    {
        $this->tmp_name = $tmp_name;
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @param string $error parameter
     *
     * @return void
     */
    public function setError(string $error): void
    {
        $this->error = $error;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size parameter
     *
     * @return void
     */
    public function setSize(int $size): void
    {
        $this->size = $size;
    }
}