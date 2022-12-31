<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/utils.php';
safe_session_start();
validar_acceso(PERFIL_TODOS, SUBSISTEMA_CYBER);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include('libs/head-common.php') ?>
    <?= inyectar_mensajes() ?>

    <title>Estadísticas: Cyber</title>
</head>

<body>
    <?php require('libs/navbar.php') ?>
    <h1 class="titulo">Sistema de inventario<br>Cyber Rodríguez</h1>
    <h2 class="titulo">Bienvenido, <?= $_SESSION['usuario']->nombre() ?></h2>
    <br>
    <div>
        <a class='buttonlink' href='/cambiarpass.php?go=<?= urlencode($_SERVER['REQUEST_URI']) ?>'>
            Cambiar contraseña
        </a>
        <a class='buttonlink' href='/internal/cambiar-subsistema.php'>
            Ir a sistema de<br>Servicio técnico
        </a>
    </div>
    <div id='popup-container'></div>
</body>

</html>