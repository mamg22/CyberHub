<?php
include_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'utils.php';
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
    <h1 class="titulo">Inventario de equipos</h1>
    <section id="main">
        <button id="agg">Agregar equipo</button>
        <div class="element-container">
            <div class="element">
                <p class="element-content">
                    <span class="big"><b>Identificador:</b> ABC-123</span>
                    <hr />
                    <b>Hardware:</b> Intel Celeron (R) @1.67 GHz, 1 GB RAM, Sin tarjeta gráfica. Disco duro 256GB
                    <hr />
                    <b>Software:</b> Windows XP Professional.
                    <hr />
                    <b>Ubicación:</b> Oficina
                    <hr />
                    <b>Estado:</b> Activo<br>
                    <b>Razón:</b>El equipo funciona correctamente, mantenimiento reciente.
                    <hr />
                </p>
                <div class="element-actions">
                    <button>Modificar</button>
                    <button>Eliminar</button>
                </div>
            </div>
            <div class="element">
                <p class="element-content">
                    <span class="big"><b>Identificador:</b> XYZ-999</span>
                    <hr />
                    <b>Hardware:</b> Intel Celeron (R) @1.67 GHz, 1 GB RAM, Sin tarjeta gráfica. Disco duro 256GB
                    <hr />
                    <b>Software:</b> Windows XP Professional.
                    <hr />
                    <b>Ubicación:</b> Oficina
                    <hr />
                    <b>Estado:</b> Activo<br>
                    <b>Razón:</b>El equipo funciona correctamente, mantenimiento reciente.
                    <hr />
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