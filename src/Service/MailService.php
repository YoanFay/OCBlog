<?php

namespace App\Src\Service;

use App\Src\Controller\Request;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class MailService
{
    /**
     * @var PHPMailer
     */
    private $mail;
    /**
     * @var Request
     */
    private $request;


    /**
     * @param string $mailTo  parameter
     * @param string $subject parameter
     * @param string $message parameter
     * @param string $name    parameter
     *
     * @throws Exception
     */
    public function __construct(string $mailTo, string $subject, string $message, string $name)
    {
        $this->request = new Request();

        $this->mail = new PHPMailer();
        $this->mail->isSMTP();
        $this->mail->CharSet = 'UTF-8';
        $this->mail->Host = 'smtp-relay.sendinblue.com';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $this->request->get('env', 'MAIL_USERNAME');
        $this->mail->Password = $this->request->get('env', 'MAIL_PASSWORD');
        $this->mail->SMTPSecure = 'tls';
        $this->mail->Port = 587;

        $this->mail->setFrom('yoanfayolle.yf@gmail.com', 'Blog');
        $this->mail->addAddress($mailTo, $name);
        $this->mail->Subject = $subject;
        $this->mail->Body = $message;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function send(): bool
    {
        if ($this->mail->send() === FALSE) {
            return false;
        }

        return true;
    }

}
