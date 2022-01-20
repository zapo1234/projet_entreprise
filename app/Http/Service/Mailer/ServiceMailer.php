<?php
namespace App\Http\Service\Mailer;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class ServiceMailer
{
   public function SendMail(string $to, string $from, string $subject, string $adresse)
   {
    //Load Composer's autoloader
     require 'vendor/autoload.php';
    //Create an instance; passing `true` enables exceptions
     $mail = new PHPMailer(true);
    
    try {
          //Server settings
           $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
           $mail->isSMTP();                                            //Send using SMTP
           $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
           $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
           $mail->Username   = 'user@example.com';                     //SMTP username
           $mail->Password   = 'secret';                               //SMTP password
           $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
           $mail->Port       = 465;                                    
           //Recipients
           $mail->setFrom($from);
           $mail->addAddress('$to', 'Elyamaje');   
           $mail->addAddress($adresse);        
           //Content
           $mail->isHTML(true);                                  
           $mail->Subject = $subject;
           $mail->Body    = $body;
           $mail->AltBody = $body;
        
           // send Mail
           $mail->send();
           echo 'Send mail';
       }    catch (Exception $e) {
          echo "eror: {$mail->ErrorInfo}";
    }
     


   }






}



