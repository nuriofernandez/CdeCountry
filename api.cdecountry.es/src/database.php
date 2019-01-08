<?php

// Include the class NL MySQL
require_once $_SERVER['DOCUMENT_ROOT'].'/src/libs/nurio.libs.basics.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/src/libs/database-config.php';

// Define NL MySQL class
$nlsql = new NL_MySqlClass($database['host'], $database['port'], $database['db'], $database['user'], $database['pass']);

?>