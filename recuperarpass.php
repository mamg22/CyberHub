<?php 
include $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'utils.php'; 
?>
<!doctype html>
<html lang="es">

<head>
<?php include('libs/head-common.php') ?>
    <?= inyectar_mensajes() ?>


    <title>Recuperación de contraseña</title>
</head>

<body class="centered-form">
    <div class="page-container">
        <h1 class="titulo">Recuperar contraseña</h1>
        <section id="main-mini">
            <form action='/internal/dorecuperacion.php' method="POST" class="inputs-login">
                <input autofocus required pattern='[0-9a-zA-Z_]+' 
                    name='nombre' class="input" type="text" placeholder="Nombre de usuario"
                    minlength="1" maxlength="25"
                    title="El nombre de usuario solo puede contener los caracteres a-z, A-Z, 0-9 y _">
                <input name='pin' class="input" type="password" placeholder="Pin de recuperación"
                    autocomplete="current-password">
                <input type='submit' class="boton" value='Recuperar'></input>
                <p><a href='/login.php' class='link'>Volver al inicio de sesión</a></p>
            </form>
        </section>
    </div>

    <div id='popup-container'></div>
</body>

</html>