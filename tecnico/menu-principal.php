<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/utils.php'; 
safe_session_start();
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
    <h1 class="titulo">Sistema de gestión<br>Servicio técnico</h1>
    <h2 class="titulo">Bienvenido, <?= $_SESSION['nombre'] ?></h2>
    <div id='popup-container'></div>
</body>
</html>

