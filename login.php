<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'utils.php'; 
safe_session_start();
?>
<!doctype html>
<html lang="es">

<head>
    <?php include('libs/head-common.php') ?>
    <title>Iniciar sesión</title>
</head>

<body class="centered-form">
    <div class="page-container">

        <h1 class="titulo">Iniciar sesión</h1>
        <section id="main-mini">
            <form class="inputs-login" action='/internal/dologin.php' method='POST'>
                <input autofocus required pattern='[0-9a-zA-Z_]+' name='nombre' class="input" type="text" placeholder="Nombre de usuario" title="El nombre de usuario solo puede contener los caracteres a-z, A-Z, 0-9 y _">
                <input required name='clave' class="input" type="password" placeholder="Contraseña">
                <button type='submit' class="boton">
                    Ingresar <span class='fa fa-sign-in-alt fa-lg'></span>
                </button>
                <p><a href='/recuperarpass.php' class='link'>¿Olvidaste la Contraseña? Click Aquí</a></p>
            </form>
        </section>
    </div>
    <div id='popup-container'></div>

</body>

</html>