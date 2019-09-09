<?php

// DEBUG MODE REMOVE!!!
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection
require_once $_SERVER['DOCUMENT_ROOT'].'/src/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/libs/PHPMailer/mailer.php';

// Set the content type
header('Content-Type: application/json');

// Parse JSON request
if(!(isset($_POST['json']))) die( json_encode( array( "error" => "invalid_request_type") ) );
$request = json_decode( $_POST['json'] , true );

// Request params validation
if( !(isset($request['email'])) && !(isset($request['password'])) && !(isset($request['token'])) ) die( json_encode( array( "error" => "invalid_request_params") ) );

// The SQL query
$prepare = $nlsql->getPDO()->prepare("SELECT `id`, `email`, `password`, `pass_salt` FROM `ciudadanos` WHERE `email`=:identificator OR `id` = :identificator");
$prepare->bindParam(":identificator", $request['email'], PDO::PARAM_STR, 400);
$prepare->execute();

// If the profile don't exist's response with error message
if($prepare->rowCount() == 0) die( json_encode( array( "error" => "authentification_error", "requested-profile" => $request['email'], "message" => "No se encontró la cuenta." ) ) );

// Obtain user information from database
$userdata = $prepare->fetch(PDO::FETCH_ASSOC);

// Verify restore token
$token_salt = hash('sha256', md5( substr($userdata['pass_salt'], 0, 10) ) );
$token_time = round(microtime(true)/60/10);

$restore_token_b = md5( md5($token_salt) . ($token_time+1) );
$restore_token = md5( md5($token_salt) . $token_time );
if( $request['token'] != $restore_token || $request['token'] != $restore_token_b ){
    die( json_encode( array( "temp" => $restore_token." : ".$restore_token_b." : ".$request['token'], "error" => "authentification_error", "requested-profile" => $request['email'], "message" => "Has superado el tiempo para restablecer la contraseña." ) ) );
}

// Generate account data
$rndString = md5( rand(1,9999),99999 );
$password = $request['password'];
$salt = md5($rndString . microtime(true));

$shaPassword = hash('sha256', $salt . hash('sha256', $password . md5($salt)) . $salt);

// The SQL query
$prepare = $nlsql->getPDO()->prepare("UPDATE `ciudadanos` SET `email`=:email, `password`=:password, `pass_salt`=:salt WHERE `email`=:identificator OR `id` = :identificator");
$prepare->bindParam(":identificator", $request['email'], PDO::PARAM_STR, 400);
$prepare->bindParam(":password", $shaPassword, PDO::PARAM_STR, 64);
$prepare->bindParam(":salt", $salt, PDO::PARAM_STR, 32);
$prepare->execute();

/* Email user */

// Headers
$to      = $request['email'];
$subject = '¡La CdeContraseña de su CdeCuenta ha sido cambiada!';

// Obtain html message from file
$htmlMessage = file_get_contents("https://new.cdecountry.es/assets/mails/restored.html");

// Create an a plain text version
$textMessage = strip_tags($htmlMessage);

// Send the email
$mail = new Mailer($to, $subject, $htmlMessage, $textMessage);

// Print the response
print( json_encode( array( "completed" => "true" ) ) );

?>