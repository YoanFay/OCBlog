<?php

namespace App\Src\Service;

use App\Src\Controller\Request;
use PHPMailer\PHPMailer\PHPMailer;

class MailService
{
    private $mail;
    private $request;

    public function __construct($mailTo, $subject, $message, $name)
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

    public function send()
    {
        if (!$this->mail->send()) {
            return false;
        }

        return true;
    }

}
