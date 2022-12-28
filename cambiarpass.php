<?php
include_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'utils.php';
safe_session_start();

?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, inicial-scale=1.0">
    <link rel="stylesheet" href="/styles/style.css">
    <script type="text/javascript" src="/libs/main.js"></script>
    <?= inyectar_mensajes() ?>

    <title>Cambiar contraseña para <?= $_SESSION['nombre'] ?></title>
</head>

<body class="centered-form">
    <div class="page-container">
        <h1 class="titulo">Cambiar contraseña para <?= $_SESSION['nombre'] ?? "???" ?></h1>

        <section id="main-mini">
            <form action='/internal/cambiar-contrasena.php' method="POST" class="inputs-login">
                <input name='clave' class="input" type="password" placeholder="Nueva contraseña">
                <input name='confclave' class="input" type="password" placeholder="Confirmar nueva contraseña">
                <input type='submit' class="boton" value='Cambiar contraseña'>
            </form>
        </section>
    </div>

    <div id='popup-container'></div>
</body>

</html>