<?php 
/************************ Variable area ************************/
$head['title'] = "Press";
$site['active-tab'] = "tab-press";
?>
<main class="container">

	<div id="paramsDiv" class="d-none">
        <param name="profileId" value="<?php echo $profileId; ?>" />
        <param name="active-tab" value="<?php echo $site['active-tab']; ?>" />
        <param name="page-title" value="<?php echo $head['title']; ?>" />
    </div>

    <div class="mb-3 d-flex align-items-center p-1 mt-1 mb-1 text-white-50 bg-white rounded box-shadow">
		<div class="lh-100 ml-1 p-2">
			<h4 class="mb-0 lh-100">Nombre Apellido</h4>
		</div>
		<div class="lh-100 mr-0 ml-auto p-2">
			<a class="btn btn-outline-success my-2 my-sm-0" href="https://gov.cdecountry.es/press/post-editor" role="button">Añadir articulo</a>
			<a class="btn btn-primary my-2 my-sm-0" href="https://gov.cdecountry.es/logout" role="button">Cerrar sesión</a>
		</div>
	</div>

	<div id="blog-list">
        <section style="margin-bottom: 40px;">
            <div class="container">
                <div class="card">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="#" target="_blank">
                                <div class="card-img-bottom" style="color: #fff; height: 100%; background: url('<?php echo "https://i.imgur.com/K59tBXu.png"; ?>') center no-repeat; background-size: cover;"></div>
                            </a>
                        </div>
                        <div class="col-md-9">
                            <div class="card-block" style="padding: 15px;">
                                <h4 class="card-title">Titulo</h4>
                                <p class="card-text">Descripción</p>
                                <a href="#" class="btn btn-primary">Seguir leyendo...</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

</main>
