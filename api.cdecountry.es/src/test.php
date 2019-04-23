<?php

require 'libs/PHPMailer/mailer.php';


$to = "xxzakkenxx@gmail.com";
$subject = "¡Entrega de tu carnet de CdeCiudadano!";
$html = file_get_contents("https://new.cdecountry.es/assets/mails/carnet.html");

$html = preg_replace('/%carnet_png%/m', "https://i.imgur.com/X3emBOJ.png", $html);

$content = strip_tags($html);

$mail = new Mailer($to, $subject, $html, $content);

?>