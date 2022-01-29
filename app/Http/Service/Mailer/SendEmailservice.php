<?php
namespace App\Http\Service\Mailer;

use App\Mail\TestMail;


class SendEmailservice
{
    private $mail;

    public function __construct(TestMail $mail)
    {
        $this->mail = $mail;
    }

    public function getBulid()
    {
        return $this->mail->build();
    }

}






