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
if(!(isset($_POST['json']))) die( json_encode( array( "error" => "invalid_request_type") ) );
$request = json_decode( $_POST['json'] , true );

// Request params validation
if( !(isset($request['token'])) ) die( json_encode( array( "error" => "invalid_request_params") ) );

// The SQL query
$prepare = $nlsql->getPDO()->prepare("SELECT `session_token`, `session_expire`, `session_cdec`, `ipAddress` FROM `user_sessions` WHERE `session_token` = :token");
$prepare->bindParam(":token", $request['token'], PDO::PARAM_STR, 32);
$prepare->execute();

// If the session don't exist's response with error message
if($prepare->rowCount() == 0) die( json_encode( array( "error" => "invalid_session", "requested-session" => $request['token'], "message" => "La session no existe." ) ) );

// Obtain session information from database
$session = $prepare->fetch(PDO::FETCH_ASSOC);

// Validate session expiration
if( $session['session_expire'] <= microtime(true) ) die( json_encode( array( "error" => "invalid_session", "message" => "La session ha expirado." ) ) );

// Validate session ip
if($_SERVER['REMOTE_ADDR'] != $session['ipAddress']) die( json_encode( array( "error" => "invalid_session", "message" => "La ip de la session no coincide." ) ) );

// Print the response
print( json_encode( array( "token" => $session['session_token'], "expire" => $session['session_expire'], "identity" => $session['session_cdec'] ) ) );

?>