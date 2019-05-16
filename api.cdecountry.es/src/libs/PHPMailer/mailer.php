<?php

// DEBUG MODE REMOVE!!!
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'libs/PHPMailer/PHPMailer.php';
require 'libs/PHPMailer/SMTP.php';
require 'libs/server-config.php';

// Setup Mailer
class Mailer {

    public $mail;

    public function __construct($to, $subject, $html, $content){

        global $mailsrv;
        $this->mail = new PHPMailer(true);
        try {
            //Disable debug
            $this->mail->SMTPDebug = false;
            $this->mail->do_debug = 0;

            //Server settings
            $this->mail->SMTPDebug = 2;
            $this->mail->isSMTP();
            $this->mail->Host = $mailsrv['host'];
            $this->mail->SMTPAuth = true;
            $this->mail->Username = $mailsrv['user'];
            $this->mail->Password = $mailsrv['password'];
            $this->mail->SMTPSecure = 'tls';
            $this->mail->Port = 587;
            $this->mail->CharSet = "utf-8";

            //Recipients
            $this->mail->setFrom($mailsrv['user'], 'Noreply');
            $this->mail->addAddress($to);

            //Content
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $html;
            $this->mail->AltBody = $content;

            $this->mail->send();
        } catch (Exception $e) {
            
        }

    }



}

?>