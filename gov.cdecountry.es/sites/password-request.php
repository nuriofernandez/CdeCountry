<?php 
/************************ Variable area ************************/
$head['title'] = "Solicitar un cambio de CdeContraseña";
$site['active-tab'] = "tab-login";
?>
<div id="dynamicDiv">
    <main class="container">

        <div id="paramsDiv" class="d-none">
            <param name="profileId" value="<?php echo $profileId; ?>" />
            <param name="active-tab" value="<?php echo $site['active-tab']; ?>" />
            <param name="page-title" value="<?php echo $head['title']; ?>" />
        </div>

        <div class="bg-white rounded box-shadow m-3 p-3">
            <h3>Has olvidado tu CdeContraseña</h3>
            <form id="password-request-form" method="POST" action="#">
                <div class="form-group mb-4">
                    <label for="email">Introduce el email con el que te registraste para buscar tu cuenta</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                </div>
                <button type="submit" class="btn btn-primary">Buscar tu cuenta</button>
            </form>
        </div>

    </main>
</div>