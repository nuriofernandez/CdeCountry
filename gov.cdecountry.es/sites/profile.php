<?php 
/************************ Variable area ************************/
$head['title'] = "Perfil";
$site['active-tab'] = "tab-login";
?>
<main class="container">

    <div id="profile-logout-bar" class="d-flex align-items-center p-1 mt-1 mb-1 text-white-50 bg-white rounded box-shadow">
        <div class="lh-100 ml-1 p-2">
            <h4 textreplaceinner="session-name" class="mb-0 lh-100">Nombre Apellido</h4>
        </div>
        <div class="lh-100 mr-0 ml-auto p-2">
            <a class="btn btn-primary my-2 my-sm-0" href="https://new.cdecountry.es/logout" role="button">Cerrar sesión</a>
        </div>
    </div>

    <div class="row">
        <div class="login col-lg bg-white rounded box-shadow m-3 py-3">
            <a id="link-twitter" href="#" target="_blank"><img id="profile-picture" src="https://avatars.io/static/default_128.jpg" class="profile-picture max-width rounded mr-3 mb-3 float-left" alt="Foto de perfil"></a>
            <div class="mt-3 pl-1">
                <h3 textreplaceinner="profile-name" id="name" class="display-5">Nombre Apellido</h3>
                <p textreplaceinner="profile-id" id="carnet-id">1</p>
            </div>
        </div>
        <div class="col-lg-8 bg-white rounded box-shadow m-3 p-3">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <h3 class="noselect">Carnet de CdeCiudadano</h3>
                    <img id="carnet-image" class="mr-auto ml-auto" style="width:100%; border-radius: 10px" src="https://i.imgur.com/X3emBOJ.png">
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
