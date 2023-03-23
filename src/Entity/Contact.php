<?php

namespace App\Src\Entity;

class Contact
{

    private $id;
    private $name;
    private $mail;
    private $message;
    private $created_at;
    private $process;
    private $process_at;
    private $process_by;
    private $answer;

    public function __construct($init = false)
    {
        if ($init == "default") {
            $this->default();
        }
    }

    public function default()
    {
        $this->created_at = date_format(new \DateTime(), 'Y-m-d H:i:s');
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     */
    public function setMail(string $mail): void
    {
        $this->mail = $mail;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
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
     * @return string|null
     */
    public function getProcess(): ?string
    {
        return $this->process;
    }

    /**
     * @param string|null $process
     */
    public function setProcess(string $process): void
    {
        $this->process = $process;
    }

    /**
     * @return mixed|null
     */
    public function getProcessAt()
    {
        return $this->process_at;
    }

    /**
     * @param mixed|null $process_at
     */
    public function setProcessAt($process_at): void
    {
        $this->process_at = $process_at;
    }

    /**
     * @return int|null
     */
    public function getProcessBy(): ?int
    {
        return $this->process_by;
    }

    /**
     * @param int|null $process_by
     */
    public function setProcessBy(int $process_by): void
    {
        $this->process_by = $process_by;
    }

    /**
     * @return string|null
     */
    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    /**
     * @param string|null $answer
     */
    public function setAnswer($answer): void
    {
        $this->answer = $answer;
    }

}