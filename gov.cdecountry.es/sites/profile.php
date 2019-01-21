<?php 
/************************ Variable area ************************/
$head['title'] = "Perfil";
$site['active-tab'] = "tab-login";
$profileId = isset($_GET['cid']) ? $_GET['cid'] : 0;
?>
<main class="container">

    <div id="paramsDiv" class="d-none">
        <param name="profileId" value="<?php echo $profileId; ?>" />
        <param name="active-tab" value="<?php echo $site['active-tab']; ?>" />
        <param name="page-title" value="<?php echo $head['title']; ?>" />
    </div>

    <div class="row">
        <div id="profile-logout-bar" class="col-lg align-items-center p-1 m-3 mb-1 text-white-50 bg-white rounded box-shadow d-none">
            <div class="lh-100 ml-1 p-2">
                <h4 textreplaceinner="session-name" class="mb-0 lh-100">Nombre Apellido</h4>
            </div>
            <div class="lh-100 mr-0 ml-auto p-2">
                <a class="btn btn-outline-secondary mr-1 my-2 my-sm-0" href="https://new.cdecountry.es/cuenta/ajustes" role="button"><i class="fas fa-cog"></i></a>
                <a class="btn btn-primary my-2 my-sm-0" jsevent="event-logout" href="#" role="button">Cerrar sesión</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="login col-lg bg-white rounded box-shadow m-3 py-3">
            <a id="link-twitter" href="#" target="_blank"><img srcreplace="profile-photo" id="profile-picture" src="https://i.imgur.com/fNWS4Bt.png" class="profile-picture max-width rounded mr-3 mb-3 float-left" alt="Foto de perfil"></a>
            <div class="mt-3 pl-1">
                <h3 textreplaceinner="profile-name" id="name" class="display-5">Nombre Apellido</h3>
                <p textreplaceinner="profile-id" id="carnet-id">1</p>
            </div>
        </div>
        <div class="col-lg-8 bg-white rounded box-shadow m-3 p-3">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <h3 class="noselect">Carnet de CdeCiudadano</h3>
                    <img srcreplace="profile-carnet" id="carnet-image" class="mr-auto ml-auto carnet-image" src="https://i.imgur.com/aZBWRqE.png">
                </li>
                <li class="list-group-item">
                    <h3 class="noselect">Licencias</h3>
                    <div id="licence-right-to-vote" class="card bg-light w-100 mt-1 mb-1">
                        <div class="card-body">
                            <h4 class="card-title">Derecho a voto</h4>
                            <p class="card-text">Como CdeCiudadano de CdeCountry tiene el derecho de participar en las votaciones.</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

</main>
