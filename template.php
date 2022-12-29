<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'utils.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>$title</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="/styles/style.css">
    <script type="text/javascript" src="/libs/main.js"></script>
    <?= inyectar_mensajes() ?>


</head>
<body>
    <?php require('libs/navbar.php') ?>
    <h1 class="titulo">$titulo</h1>
    <div id='popup-container'></div>
</body>
</html>