<?php

require 'libs/PHPMailer/mailer.php';


$to = "xxzakkenxx@gmail.com";
$subject = "This is a test message, don't panic.";
$html = "Inside this string i can use html tags. <b>jejejejjejeje</b>";
$content = "Minium message here";

$mail = new Mailer($to, $subject, $html, $content);

?>