<?php

// Prevent null input
$cid = isset($_GET['cdec_id']) ? $_GET['cdec_id'] : null;
if(strlen($cid) != 12) die("ERROR: CdeCarnet invalido.");
if($cid == null) die("ERROR: CdeCarnet inexistente.");

?>
<html>
   <head>

      <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
      <link href="https://new.cdecountry.es/frames/CarnetRender/style.css" rel="stylesheet">

      <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
      <script type="text/javascript" src="https://gov.cdecountry.es/inc/js/jquery-3.3.1.js"></script>
      <script type="text/javascript" src="https://gov.cdecountry.es/inc/js/jquery.qrcode.min.js"></script>
      <script type="text/javascript" src="https://new.cdecountry.es/frames/CarnetRender/scripts.js"></script>
      
      <script type="text/javascript" src="https://new.cdecountry.es/assets/js/base.js"></script>

   </head>
   <body>

      <div id="carnet" class="container">
         <img src="https://new.cdecountry.es/assets/img/carnet/front.png">
         <div id="qrcode" class="bottom-left"></div>
         <div id="identity" class="bottom-right"><?php echo $cid; ?></div>
      </div>

   </body>
</html>