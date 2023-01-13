<?php
include_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'utils.php';


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

    <script>
        function validar_confimacion_clave(ev) {
            var clave = document.querySelector('*[name="clave"]');
            var confirmacion = document.querySelector('*[name="confclave"]');
            if (clave.value !== confirmacion.value) {
                clave.setCustomValidity(
                    "La contraseña y la confirmación de la contraseña no coinciden. Por favor, introduzcala de nuevo.");
            }
            else {
                clave.setCustomValidity('');
            }
        }

        function setup_validacion() {
            var clave = document.querySelector('*[name="clave"]');
            var confclave = document.querySelector('*[name="confclave"]');
            clave.addEventListener('input', validar_confimacion_clave);
            confclave.addEventListener('input', validar_confimacion_clave);
        }

        window.addEventListener('DOMContentLoaded', setup_validacion)
        </script>

    <title>Cambiar contraseña para <?= $nombre ?></title>
</head>

<body class="centered-form">
    <div class="page-container">
        <h1 class="titulo">Cambiar contraseña para <?= $nombre ?></h1>

        <section id="main-mini">
            <form action='/internal/cambiar-contrasena.php' method="POST" class="inputs-login">
                <?= help_icon("La contraseña debe contener al menos 8 caracteres, incluyendo una mayúscula, una minúscula y un número") ?>
                <input required name='clave' class="input" type="password" placeholder="Nueva contraseña"
                    minlength="8" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                    title="La contraseña debe contener al menos 8 caracteres, incluyendo una mayúscula, una minúscula y un número">
                <input required name='confclave' class="input" type="password" placeholder="Confirmar nueva contraseña"
                    minlength="8">
                <button type='submit' class="boton">Cambiar contraseña</button>
                <p><a href='/' class='link'>Volver al inicio</a></p>
            </form>
        </section>
    </div>

    <div id='popup-container'></div>
</body>

</html>