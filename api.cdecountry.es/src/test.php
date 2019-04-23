<?php

require 'libs/PHPMailer/mailer.php';


$to = "xxzakkenxx@gmail.com";
$subject = "This is a test message, don't panic.";
$html = file_get_contents("https://new.cdecountry.es/assets/mails/carnet.html");
$content = strip_tags($html);

$mail = new Mailer($to, $subject, $html, $content);

?>