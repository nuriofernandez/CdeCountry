<?php 
/************************ Variable area ************************/
$head['title'] = "Iniciar Sesión";
$site['active-tab'] = "tab-login";
?>
<main class="container">
    <div class="row">
        <div class="col-lg-8 bg-white rounded box-shadow m-3 p-3">
            <h1 class="noselect text-center">¿Aún no eres CdeCiudadano?</h1>
            <a href="ciudadania">
                <div class="m-4 p-4 bg-white rounded">
                    <h2 class="noselect text-center">Solicitar CdeCiudadania</h2>
                    <div class="d-flex">
                        <img class="max-width noselect mr-auto ml-auto" src="https://new.cdecountry.es/assets/img/solicita-cdecarnet.png">
                    </div>
                </div>
            </a>
        </div>
        <div class="login col-lg bg-white rounded box-shadow m-3 py-3">
            <h3 class="mb-0">Inicio de sesión</h3>
            <small id="invalid-login-text" class="text-danger d-none">Email, ID o contraseña incorrecta.</small>
            <form class="mb-4" action="#" method="POST" >
                <div class="form-group mt-3">
                    <label for="user_id">Email o ID</label>
                    <input type="email" class="form-control" name="user_id" id="user_id" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="user_pass">Contraseña</label>
                    <input type="password" class="form-control" name="user_pass" id="user_pass" autocomplete="current-password">
                    <small class="form-text text-muted"><a href="https://new.cdecountry.es/cuenta/restablecer">Restablecer contraseña</a></small>
                </div>
                <button jsevent="btn-login" type="submit" class="btn btn-primary">Iniciar sesión</button>
            </form>
            <div>
                <b>¿Cual es mi contraseña?</b>
                <p>Al solicitar tu CdeCiudadanía recibes una contraseña temporal. Si aún no has cambiado esa contraseña, será esa tu contraseña.<br/><small>CdeCountry recomienda cambiar la contraseña temporal.</small></p>
            </div>
        </div>
    </div>
</main>