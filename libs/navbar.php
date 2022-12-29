<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'utils.php'; 
safe_session_start();
?>
<nav>
    <?php
    if ($_SESSION['subsistema_actual'] === SUBSISTEMA_CYBER) {
    ?>
        <div><a href="/cyber/menu-principal.php">Inicio</a></div>
        <div>Inventario<br>Equipos</div>
        <div>Inventario<br>Repuestos</div>
        <div>Estadísticas</div>
    <?php
    } else {
    ?>
        <div><a href="/tecnico/menu-principal.php">Inicio</a></div>
        <div>Trabajos</div>
        <div>Clientes</div>
        <div>Estadísticas</div>
    <?php
    }
    ?>
    <div><a href='/internal/dologout.php'>Cerrar<br>Sesión</a></div>
</nav>