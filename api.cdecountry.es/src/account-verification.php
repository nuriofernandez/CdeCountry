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
if( !(isset($request['token'])) && !(isset($request['image'])) ) die( json_encode( array( "error" => "invalid_request_params") ) );

// Parse request data
$tokenId = intval($request['token']);

// Obtain account details
$prepare = $nlsql->getPDO()->prepare("SELECT `id`, `carnet_png` FROM `ciudadanos` WHERE `verify_token`=:token");
$prepare->bindParam(":token", $tokenId, PDO::PARAM_STR, 400);
$prepare->execute();

// If the profile don't exist's response with error message
if($prepare->rowCount() == 0) die( json_encode( array( "error" => "invalid_session", "requested-session" => $tokenId, "message" => "La session no existe." ) ) );

// Obtain user information from database
$userdata = $prepare->fetch(PDO::FETCH_ASSOC);

if( $userdata['carnet_png'] != null || strlen($userdata['carnet_png']) > 3 ) die( json_encode( array( "error" => "invalid_request", "requested-token" => $tokenId, "message" => "Esta cuenta ya está verificada.", "carnet" => $userdata['carnet_png'] ) ) );

// The SQL query
$prepare = $nlsql->getPDO()->prepare("UPDATE `ciudadanos` SET `carnet_png`=:imageid WHERE `verify_token`=:token");
$prepare->bindParam(":token", $tokenId, PDO::PARAM_STR, 32);
$prepare->bindParam(":imageid", $request['image'], PDO::PARAM_STR, 15);
$prepare->execute();

// Print the response
print( json_encode( array( "token" => $tokenId, "image" => $request['image'], "identity" => $userdata['id'] ) ) );

?>