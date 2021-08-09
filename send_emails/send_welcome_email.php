<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once("{$_SERVER['DOCUMENT_ROOT']}/PHPMailer/src/PHPMailer.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/PHPMailer/src/SMTP.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/PHPMailer/src/Exception.php");

function send_email($email, $url)
{
    $configs = include(__DIR__ . '/credentials.php');

    //Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = false;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $configs['username'];                     //SMTP username
        $mail->Password   = $configs['password'];                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('examkea@gmail.com', 'Web Class KEA');
        $mail->addAddress("$email", 'The user');     //Add a recipient


        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Welcome';
        $mail->Body    = "<p style='padding:5px'>Welcome $email! Verify your account by clicking on <a href='$url'> here </a></p>";
        $mail->AltBody = "Welcome! Verify your account by clicking on $url";

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
