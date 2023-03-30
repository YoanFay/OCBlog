<?php

namespace App\Src\Entity;

class Contact
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
    private $mail;

    /**
     * @return string
     */
    private $message;

    /**
     * @return string
     */
    private $created_at;

    /**
     * @return string
     */
    private $process;

    /**
     * @return string
     */
    private $process_at;

    /**
     * @return string
     */
    private $process_by;

    /**
     * @return string
     */
    private $answer;

    /**
     * @param bool $init
     */
    public function __construct(bool $init = false)
    {
        if ($init == "default") {
            $this->default();
        }
    }

    /**
     * @return void
     */
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
     * @param int $id    parameter
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
     * @param string $name    parameter
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
     * @param string $mail    parameter
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
     * @param string $message    parameter
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
     * @param mixed $created_at    parameter
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
     * @param string|null $process    parameter
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
     * @param mixed|null $process_at    parameter
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
     * @param int|null $process_by    parameter
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
     * @param string|null $answer    parameter
     */
    public function setAnswer($answer): void
    {
        $this->answer = $answer;
    }

}