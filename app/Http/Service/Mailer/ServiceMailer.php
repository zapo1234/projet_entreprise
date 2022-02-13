<?php
namespace App\Http\Service\Mailer;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class ServiceMailer
{
   public function SendMail(string $to, string $from, string $subject, string $adresse, string $message)
   {
       //Load Composer's autoloader
       require 'vendor/autoload.php';
       //instant de mailer 
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
           $mail->Port       = 587;   
           //encode Utf 8
           $mail->CharSet = 'UTF-8';                               
           //Recipients
           $mail->setFrom($from);
           $mail->addAddress($to, 'Elyamaje');   
           $mail->addAddress($adresse);        
           //Content
           $mail->isHTML(true);                                  
           $mail->Subject = $subject;
           $mail->Body    = $message;
           $mail->AltBody = $message;
        
           // send Mail
           $mail = $mail->send();
           if($mail)
           {
              echo 'Send mail';
           }
           else
           {
             dd('echec d\'envoi');
           }
       }    catch (Exception $e) {
          echo "eror: {$mail->ErrorInfo}";
    }
     
   }

}



