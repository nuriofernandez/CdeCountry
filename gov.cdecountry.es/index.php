<?php
/************************ Variable area ************************/
$site['file'] = isset($_GET['web']) ? $_GET['web'] : "home";
$head['site_name'] = "CdeCountry";
$head['title'] = "Home";

$cfg['site_domain'] = "https://new.cdecountry.es";
$site['active-tab'] = "";

/************************ Content area ************************/
ob_start();
$include_return = include("sites/".$site['file'].".php");
$string = ob_get_contents();
ob_end_clean();

?>
<!doctype html>
<html lang="en">
	<head>
		<title><?php echo $head['title'] . " | " . $head['site_name']; ?></title>
		<meta charset="utf-8">
		<meta name="description" content="">
		<meta name="author" content="xXNurioXx">

		<!-- 3thrd part styles -->
		<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		
		<!-- Site static head -->
		<link rel="shortcut icon" type="image/png" href="https://new.cdecountry.es/assets/img/logo.png"/>
		<link rel="stylesheet" type="text/css" href="https://new.cdecountry.es/assets/css/style.css">

		<!-- Site dinamic head -->
		<param id="active-tab" value="<?php echo $site['active-tab']; ?>">
	<body>
		
		<!-- Navbar -->
		<nav class="navbar navbar-expand navbar-dark bg-dark">
			<div class="container">
				<a class="navbar-brand" href="https://new.cdecountry.es">
					<img src="https://new.cdecountry.es/assets/img/banner-logo.png" width="325" height="80" class="d-inline-block align-top" alt="">
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarsExample02">
					<ul class="navbar-nav ml-auto">
						<li id="tab-tv" class="nav-item">
							<a class="nav-link" href="https://new.cdecountry.es/TV"><i class="fas fa-tv"></i> <text id="tab-tv-title">Televisión</text></a>
						</li>
						<li id="tab-map"  class="nav-item">
							<a class="nav-link" href="https://new.cdecountry.es/mapa"><i class="fas fa-map"></i> <text id="tab-map-title">Mapa</text></a>
						</li>
						<li id="tab-press" class="nav-item">
							<a class="nav-link" href="https://new.cdecountry.es/press"><i class="far fa-newspaper"></i> <text id="tab-press-title">Prensa</text></a>
						</li>
						<li id="tab-login" class="nav-item">
							<a class="nav-link" href="https://new.cdecountry.es/login"><i class="fas fa-user-circle"></i> <text id="tab-login-title">Identificación</text></a>
						</li>
					</ul>
				</div>
			</div>
		</nav>

		<!-- Web content -->
		<?php echo str_replace("\n", "\n\t\t", $string)."\n"; ?>

		<!-- Footer -->
		<footer class="footer notranslate">
			<div class="container">
				<span class="float-left footer-text noselect"><a target="_blank" class="link-no" href="https://twitter.com/cdecountry"><i class="fab fa-twitter"></i> @CdeCountry</a> | Sitio creado por <a target="_blank" class="link-no" href="https://nurio.me">Nurio Noroty</a></span>
				<span class="float-right footer-text noselect">Made in Earth by Humans</span>
			</div>
		</footer>

		<!-- Common JS -->
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>

		<!-- Site JS -->
		<script type="text/javascript" src="https://new.cdecountry.es/assets/js/base.js"></script>

		<!-- Google Analitys Include !-->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-89267571-4"></script>

	</body>
</html>