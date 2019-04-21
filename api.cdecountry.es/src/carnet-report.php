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
if( !(isset($request['imgur_id'])) ) die( json_encode( array( "error" => "invalid_request_params") ) );

// Print the response
print( json_encode( array( "imgur_id" => $request['imgur_id'], "identity" => $session['session_cdec'] ) ) );

?>