<?php

// DEBUG MODE REMOVE!!!
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/libs/PHPMailer/mailer.php';

// Set the content type
header('Content-Type: application/json');

// Parse JSON request
if(!(isset($_POST['json']))) die( json_encode( array( "error" => "invalid_request_type") ) );
$request = json_decode( $_POST['json'] , true );

// Request params validation
if( !(isset($request['name'])) || !(isset($request['email'])) ) die( json_encode( array( "error" => "invalid_request_params") ) );

// Verify if email is already used
$prepare = $nlsql->getPDO()->prepare("SELECT `id`, `email`, `password`, `pass_salt` FROM `ciudadanos` WHERE `email`=:email");
$prepare->bindParam(":email", $request['email'], PDO::PARAM_STR, 400);
$prepare->execute();

// If the profile exist's response with error message
if($prepare->rowCount() != 0) die( json_encode( array( "error" => "register_error", "email" => $request['email'], "message" => "Este correo ya está registrado." ) ) );

// Generate account data
$rndString = md5( rand(1,9999),99999 );
$password = substr(md5($rndString . microtime(true)),16);
$salt = md5($rndString . microtime(true));
$sha = hash('sha256', $salt . hash('sha256', $password . md5($salt)) . $salt);
$token_verify = md5($rndString . $request['email']);

// Insert account data onto DB
$prepare = $nlsql->getPDO()->prepare("INSERT INTO `ciudadanos`(`verify_token`,`password`,`pass_salt`,`nombre`, `email`".(isset($request['twitter']) ? ",`twitter`" : "").") VALUES (:verify, :pass,:salt,:name,:mail".(isset($request['twitter']) ? ",:twitter" : "").")");
$prepare->bindParam(":name", $request['name'], PDO::PARAM_STR, 100);
$prepare->bindParam(":mail", $request['email'], PDO::PARAM_STR, 400);
$prepare->bindParam(":pass", $sha, PDO::PARAM_STR, 128);
$prepare->bindParam(":salt", $salt, PDO::PARAM_STR, 32);
$prepare->bindParam(":verify", $token_verify, PDO::PARAM_STR, 32);

if(isset($request['twitter']))$prepare->bindParam(":twitter", $request['twitter'], PDO::PARAM_STR, 32);
$prepare->execute();

/* Email user */

// Headers
$to      = $request['email'];
$subject = '¡Su solicitud de CdeCiudanía fue aceptada!';

// Obtain html message from file
$htmlMessage = file_get_contents("https://new.cdecountry.es/assets/mails/verification.html");

// Replace variables of the message
$htmlMessage = preg_replace('/%var_name%/m', $request['name'], $htmlMessage);
$htmlMessage = preg_replace('/%var_email%/m', $request['email'], $htmlMessage);
$htmlMessage = preg_replace('/%var_password%/m', $password, $htmlMessage);
$htmlMessage = preg_replace('/%var_verify_token%/m', $token_verify, $htmlMessage);

// Create an a plain text version
$textMessage = strip_tags($htmlMessage);

// Send the email
$mail = new Mailer($to, $subject, $htmlMessage, $textMessage);

// Print the response
print( json_encode( array( "registered" => "true" ) ) );

?>