<?php 
include $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'utils.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Administración de usuarios</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="/styles/style.css">
    <script type="text/javascript" src="/libs/main.js"></script>
    <?= inyectar_mensajes() ?>


</head>
<body>
    <?php require('navbar.php') ?>
    <h1 class="titulo">Administración de usuarios</h1>
    <section id="main">
        <button id="agg">Registrar usuario</button>
        <div class="element-container">
            <div class="element">
                <p class="element-content">
                    <span class="big"><b>Usuario1</b></span>
                    <hr/>
                    <b>Cédula:</b> V-27669598
                    <hr/>
                    <b>Subsistema:</b> Cyber
                    <hr/>
                    <b>Perfil:</b> Administrador
                </p>
                <div class="element-actions">
                    <button>Modificar</button>
                    <button>Eliminar</button>
                </div>
            </div>
            <div class="element">
                <p class="element-content">
                    <span class="big"><b>Usuario2</b></span>
                    <hr/>
                    <b>Cédula:</b> V-12315439
                    <hr/>
                    <b>Subsistema:</b> Cyber
                    <hr/>
                    <b>Perfil:</b> Regular
                </p>
                <div class="element-actions">
                    <button>Modificar</button>
                    <button>Eliminar</button>
                </div>
            </div>
        </div>
    </section>
    <div id='popup-container'></div>
</body>
</html>


