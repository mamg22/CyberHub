<?php
include_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'utils.php';
safe_session_start();

try {
    $nombre = $_SESSION['recovery_nombre'] ?? $_SESSION['usuario']->nombre();
}
catch (Throwable $e) {
    $nombre = "???";
}

?>
<!doctype html>
<html lang="es">

<head>
<?php include('libs/head-common.php') ?>
    <?= inyectar_mensajes() ?>

    <title>Cambiar contraseña para <?= $nombre ?></title>
</head>

<body class="centered-form">
    <div class="page-container">
        <h1 class="titulo">Cambiar contraseña para <?= $nombre ?></h1>

        <section id="main-mini">
            <form action='/internal/cambiar-contrasena.php' method="POST" class="inputs-login">
                <input name='clave' class="input" type="password" placeholder="Nueva contraseña">
                <input name='confclave' class="input" type="password" placeholder="Confirmar nueva contraseña">
                <button type='submit' class="boton">Cambiar contraseña</button>
                <p><a href='/' class='link'>Volver al inicio</a></p>
            </form>
        </section>
    </div>

    <div id='popup-container'></div>
</body>

</html>