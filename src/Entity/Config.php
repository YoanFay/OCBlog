<?php

namespace App\Src\Entity;

class Config
{

    /**
     * @var
     */
    private $id;

    /**
     * @var
     */
    private $image;

    /**
     * @var
     */
    private $catch_phrase;

    /**
     * @var
     */
    private $title;

    /**
     * @var
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
     * @param int $id    parameter
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
     * @param string|null $image    parameter
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
     * @param string $catch_phrase    parameter
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
     * @param string $title    parameter
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
     * @param string|null $cv    parameter
     */
    public function setCv(?string $cv): void
    {
        $this->cv = $cv;
    }
}