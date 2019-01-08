<?php

// DEBUG MODE REMOVE!!!
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection
require_once $_SERVER['DOCUMENT_ROOT'].'/src/database.php';

// Set the content type
header('Content-Type: application/json');

// Parse JSON request
if(!(isset($_POST['json'])) die( json_encode( array( "error" => "Invalid request type") ) );
$request = json_decode( $_POST['json'] , true );

// Request params validation
if( !(isset($request['identity'])) || !(isset($request['password'])) ) die( json_encode( array( "error" => "invalid_authentification_params") ) );

// The SQL query
$prepare = $nlsql->getPDO()->prepare("SELECT `id`, `email`, `password`, `pass_salt` FROM `ciudadanos` WHERE `email`=:identificator OR `id` = :identificator");
$prepare->bindParam(":identificator", $request['identity'], PDO::PARAM_STR, 400);
$prepare->execute();

// If the profile don't exist's response with error message
if($prepare->rowCount() == 0) die( json_encode( array( "error" => "authentification_error", "requested-profile" => $request['identity'], "message" => "No se encontro la cuenta." ) ) );

// Obtain user information from database
$row = $prepare->fetch(PDO::FETCH_ASSOC);

// Create user password hash 
$hashedCredential = hash('sha256', $row['pass_salt'] . hash('sha256', $request['password'] . md5($salt)) . $salt);

// Validate user password hashes
if($hashedCredential != $row['password']) die( json_encode( array( "error" => "authentification_error", "message" => "La contraseña no es invalida." ) ) );

// Create new session
$session['expire'] = microtime(true) + (1000*60*60*24);
$session['identity'] = $row['id'];
$session['ip'] = $_SERVER['REMOTE_ADDR'];
$session['token'] = md5($ipAddress + microtime(true));

// Do an a sql call inserting the session data
$prepare2 = $nlsql->getPDO()->prepare("INSERT INTO `user_sessions`(`session_token`, `session_expire`, `session_cdec`, `ipAddress`) VALUES (:token, :expire, :cdec, :ip)");
$prepare2->bindParam(":token", $tok, PDO::PARAM_STR, 16);
$prepare2->bindParam(":expire", $expire, PDO::PARAM_STR, 21);
$prepare2->bindParam(":cdec", $cdec, PDO::PARAM_STR, 11);
$prepare2->bindParam(":ip", $ipAddress, PDO::PARAM_STR, 15);

// Print the response
print( json_encode(  ) );

?>