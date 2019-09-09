<?php 
/************************ Variable area ************************/
$head['title'] = "CdeCambiar la CdeContraseña";
$site['active-tab'] = "tab-login";
$token = isset($_GET['token']) ? $_GET['token'] : die("Error.");
?>
<div id="dynamicDiv">
    <main class="container">

        <div id="paramsDiv" class="d-none">
            <param name="profileId" value="<?php echo $profileId; ?>" />
            <param name="active-tab" value="<?php echo $site['active-tab']; ?>" />
            <param name="page-title" value="<?php echo $head['title']; ?>" />
            <param name="restore-token" value="<?php echo $token; ?>" />
        </div>

        <div class="bg-white rounded box-shadow m-3 p-3">
            <h3>Restablecer la contraseña</h3>
            <small id="invalid-restore-text" class="d-none text-danger">No se encontró la cuenta.</small>
            <form id="password-restore-form" method="POST" action="#" jsevent="password-restore-form">
                <div class="form-group mb-4">
                    <label for="email">Dirección email de la CdeCuenta:</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                </div>
                <div class="form-group mb-4">
                    <label for="password">Introduce una nueva contraseña:</label>
                    <input type="password" class="form-control" id="password" name="password" aria-describedby="password">
                </div>
                <div class="form-group mb-4">
                    <label for="cpassword">Confirma tu nueva contraseña:</label>
                    <input type="cpassword" class="form-control" id="cpassword" name="cpassword" aria-describedby="password">
                </div>
                <button type="submit" class="btn btn-primary">Restablecer contraseña</button>
            </form>
        </div>

    </main>
</div>