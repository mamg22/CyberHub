<?php 
include $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'utils.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Registrar nuevo usuario</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="/styles/style.css">
    <script type="text/javascript" src="/libs/main.js"></script>
    <?= inyectar_mensajes() ?>

</head>
<body>
    <?php require('libs/navbar.php') ?>
    <h1 class="titulo">Registrar nuevo usuario</h1>
    <section id="main">
        <div class="form-central">
        <form class="insform">
            <div>
            <label>Nombre de usuario:</label>
            <input name='nombre' type="text" placeholder="Nombre"></input>
            </div>
            <div>
            <label>Cédula:</label>
            <input name='cedula' type="text" placeholder="Cédula"></input>
            </div>
            <div>
            <label>Contraseña:</label>
            <input name='clave' type="password" placeholder="Contraseña"></input>
            </div>
            <div>
            <label>Confirmar contraseña:</label>
            <input name='confclave' type="password" placeholder="Confirmar contraseña"></input>
            </div>
            <div>
            <label>Pin de recuperación:</label>
            <input name='pin' type="password" placeholder="Pin"></input>
            </div>
            <div>
            <label>Confirmar pin de recuperación:</label>
            <input name='confpin' type="password" placeholder="Confirmar pin"></input>
            </div>
            <hr/>
            <div>
            
            <label>Perfil:</label>
            <select name='perfil' class="selector">
                <option>Regular</option>
                <option>Administrador</option>
                <option>Solo lectura</option>
            </select>
            </div>
            <div class="element-actions">
                <input type='button'>Cancelar</input>
                <input type='submit'>Registrar</input>
            </div>
        </form>
        </div>
    </section>
    <div id='popup-container'></div>
</body>
</html>


