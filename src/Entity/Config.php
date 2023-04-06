<?php

namespace App\Src\Entity;

class Config
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $image;

    /**
     * @var string
     */
    private $catch_phrase;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $cv;

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
     * @return string
     */
    public function getCatchPhrase(): string
    {
        return $this->catch_phrase;
    }

    /**
     * @param string $catch_phrase parameter
     *
     * @return void
     */
    public function setCatchPhrase(string $catch_phrase): void
    {
        $this->catch_phrase = $catch_phrase;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title parameter
     *
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getCv(): ?string
    {
        return $this->cv;
    }

    /**
     * @param string|null $cv parameter
     *
     * @return void
     */
    public function setCv(?string $cv): void
    {
        $this->cv = $cv;
    }
}