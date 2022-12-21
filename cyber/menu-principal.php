<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/utils.php'; 
safe_session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Estadísticas: Cyber</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="/styles/style.css">
</head>
<body>
    <?php require('navbar.php') ?>
    <h1 class="titulo">Sistema de inventario<br>Cyber Rodríguez</h1>
    <h2 class="titulo">Bienvenido, <?= $_SESSION['nombre'] ?></h2>
</body>
</html>

