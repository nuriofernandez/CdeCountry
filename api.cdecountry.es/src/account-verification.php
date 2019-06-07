<?php

// DEBUG MODE REMOVE!!!
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection
require_once $_SERVER['DOCUMENT_ROOT'].'/src/database.php';

// Set the content type
header('Content-Type: application/json');

// If the profile id isn't exist's response with error message
if( !(isset($_GET['id'])) ) die( json_encode( array( "error" => "Please specify an a carnet id") ) );

// If the carnet image id isn't exist's response with error message
if( !(isset($_GET['carnet'])) ) die( json_encode( array( "error" => "Please specify an a carnet id") ) );


// The SQL query
$prepare = $nlsql->getPDO()->prepare("SELECT `id`, `nombre`, `twitter`, `carnet_png`, `permissions` FROM `ciudadanos` WHERE `id`=:id ");
$prepare->bindParam(":id", $_GET['id'], PDO::PARAM_INT, 15);
$prepare->execute();

// If the profile don't exist's response with error message
if($prepare->rowCount() == 0) die( json_encode( array( "error" => "This profile dosn't exist's", "requested-profile" => $_GET['id']) ) );

// Print the response
print( json_encode( $prepare->fetch(PDO::FETCH_ASSOC) ) );

?>