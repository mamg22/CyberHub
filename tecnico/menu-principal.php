<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/utils.php'; 
safe_session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Estadísticas: Cyber</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="/styles/style.css">
    <script type="text/javascript" src="/libs/main.js"></script>
    <?= inyectar_mensajes() ?>


</head>
<body>
    <?php require('libs/navbar.php') ?>
    <h1 class="titulo">Sistema de gestión<br>Servicio técnico</h1>
    <h2 class="titulo">Bienvenido, <?= $_SESSION['nombre'] ?></h2>
    <div id='popup-container'></div>
</body>
</html>

