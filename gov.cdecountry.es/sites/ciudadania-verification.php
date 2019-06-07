<?php 
/************************ Variable area ************************/
$head['title'] = "Verificación de CdeCiudadanía";
$site['active-tab'] = "none";
?>
<div id="dynamicDiv">
    <main class="container">
        <div class="my-3 p-3 bg-white rounded box-shadow">
            <div class="d-flex align-items-center p-3 my-3 text-white-50">
                <div class="ml-auto mr-1">
                    <img class="mr-auto ml-auto" src="https://i.imgur.com/qQEZxk2.gif" alt="">
                </div>
                <div class="ml-5 mr-auto">
                    <h1 class="mb-0 ">Verificando identidad...</h1>
                    <h4 class="mb-0 lh-100">Esto puede tardar unos segundos...</h4>
		            <small>Creando <b>Carnet de CdeCiudadano</b>...</small> <?php echo $_GET['token'];?>
                </div>
            </div>
        </div>
    </main>
</div>