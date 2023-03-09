<?php

namespace App\Src\Core;

class Mail
{
    private $destinataire = 'yoanfayolle.yf@gmail.com';
    private $sujet = 'Demande de contact de ';
    private $message;
    private $headers = 'From: ';

    public function __construct($mail)
    {
        $this->message = $mail['message'];
        $this->headers .= $mail['recipient'];
        $this->sujet .= $mail['name'];
    }

    public function send()
    {
        if (mail($this->destinataire, $this->sujet, $this->message, $this->headers)) {
            return true;
        }

        return false;
    }
}