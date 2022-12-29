<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'utils.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="/styles/style.css">
    <script type="text/javascript" src="/libs/main.js"></script>
    <?= inyectar_mensajes() ?>

    <title>Registrar nuevo equipo</title>
</head>
<body>
    <?php require('libs/navbar.php') ?>
    <h1 class="titulo">Registrar nuevo equipo</h1>
    <section id="main">
        <div class="form-central">
        <form class="insform">
            <div>
            <label>Identificador:</label><input type="text" placeholder="Identificador"></input>
            </div>
            <div>
            <label>Hardware:</label><br>
            <textarea cols="80" rows="6" placeholder="Descripción del hardware"></textarea>
            </div>
            <div>
            <label>Software:</label><br>
            <textarea cols="80" rows="6" placeholder="Descripción del software"></textarea>
            </div>
            <div>
            <label>Ubicación:</label>
            <select class="selector">
                <option>Oficina</option>
                <option>Sala 1</option>
                <option>Sala 2</option>
            </select>
            </div>
            <div>
            <label>Estado:</label>
            <select class="selector">
                <option>Activo</option>
                <option>Inactivo</option>
                <option>Desincorporado</option>
            </select>
            </div>
            <div>
            <label>Razón de estado:</label><br>
            <textarea cols="80" rows="6" placeholder="Descripción del estado del equipo"></textarea>
            </div>
            <!--
            <div>
            <label>Perfil:</label>
            <select class="select-perfil">
                <option>Regular</option>
                <option>Administrador</option>
                <option>Solo lectura</option>
            </select>
            </div>
            -->
            <div class="element-actions">
                <button>Cancelar</button>
                <button>Registrar</button>
            </div>
        </form>
        </div>
    </section>
    <div id='popup-container'></div>
</body>
</html>

