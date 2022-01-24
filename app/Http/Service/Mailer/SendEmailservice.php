<?php
namespace App\Http\Service\Mailer;

use App\Mail\TestMail;


class SendEmailservice
{
    public $mail;

    public function __construct(TestMail $mail)
    {
        $this->mail = $mail;
    }

    public function getBulid()
    {
        return $mail->build();
    }

}






