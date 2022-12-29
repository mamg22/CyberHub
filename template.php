<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'utils.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include('libs/head-common.php') ?>
    <?= inyectar_mensajes() ?>

    <title>$title</title>

</head>
<body>
    <?php require('libs/navbar.php') ?>
    <h1 class="titulo">$titulo</h1>
    <div id='popup-container'></div>
</body>
</html>