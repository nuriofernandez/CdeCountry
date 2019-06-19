<?php
// Prevent null input
$token = isset($_GET['token']) ? $_GET['token'] : null;
if($token == null || strlen($token) != 32) die("ERROR: Token invalido.");

// DEBUG MODE REMOVE!!!
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection
require_once $_SERVER['DOCUMENT_ROOT'].'/src/database.php';

// The SQL query
$prepare = $nlsql->getPDO()->prepare("SELECT `id`, `nombre`, `twitter`, `carnet_png`, `permissions` FROM `ciudadanos` WHERE `verify_token`=:token ");
$prepare->bindParam(":token", $token, PDO::PARAM_INT, 32);
$prepare->execute();

if($prepare->rowCount() == 0) die( "ERROR: Token incorrecto." );

$userdata = $prepare->fetch(PDO::FETCH_ASSOC);


?>
<html>
   <head>

      <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
      <link href="https://api.cdecountry.es/render/carnet/style.css" rel="stylesheet">

      <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
      <script type="text/javascript" src="https://gov.cdecountry.es/inc/js/jquery-3.3.1.js"></script>
      <script type="text/javascript" src="https://gov.cdecountry.es/inc/js/jquery.qrcode.min.js"></script>
      <script type="text/javascript" src="https://new.cdecountry.es/assets/js/base.js"></script>
      <script type="text/javascript" src="https://api.cdecountry.es/render/carnet/script.js"></script>


   </head>
   <body>

      <div id="paramsDiv" class="d-none">
         <param name="token" value="<?php echo $token; ?>" />
      </div>

      <div id="carnet" class="container">
         <img src="https://new.cdecountry.es/assets/img/carnet/front.png">
         <div id="qrcode" class="bottom-left"></div>
         <div id="identity" class="bottom-right"><?php echo $userdata['id']; ?></div>
      </div>

   </body>
</html>