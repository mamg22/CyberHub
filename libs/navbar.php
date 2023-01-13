<?php
include_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'utils.php';

$sub_actual = $_SESSION['subsistema_actual'];
if ($sub_actual === SUBSISTEMA_SERVICIO) {
    $sub_otro = "Cyber Rodríguez";
}
else {
    $sub_otro = "Servicio Técnico";
}
?>
<header>
    <nav>
        <div class='nav-item' id='nav-user-info'>
            <span class='fa fa-fw fa-user'></span> <?= $_SESSION['usuario']->nombre() ?>
        </div>
        <div class='nav-item' id='nav-menu'>
            <span class='fa fa-fw fa-bars fa-lg' id='nav-menu-icon'></span> Menú
        </div>
    </nav>
    <div id="main-menu">
        <a class='menu-item' href="/"><span class='fa fa-fw fa-home'></span> Inicio</a>
        <?php
        if ($_SESSION['subsistema_actual'] === SUBSISTEMA_CYBER) {
        ?>
            <a class='menu-item' href='/cyber/equipos/'><span class='fa fa-fw fa-desktop'></span> Inventario: Equipos</a>
            <a class='menu-item' href='/cyber/repuestos/'><span class='fa fa-fw fa-memory'></span> Inventario: Repuestos</a>
            <a class='menu-item' href='/cyber/estadisticas.php'><span class='fa fa-fw fa-chart-pie'></span> Estadísticas</a>
        <?php
        } else {
        ?>
            <a class='menu-item' href='/tecnico/trabajos/'><span class='fa fa-fw fa-list'></span> Trabajos </a>
            <a class='menu-item' href='/tecnico/clientes/'><span class='fa fa-fw fa-address-card'></span> Clientes</a>
            <a class='menu-item' href='/tecnico/estadisticas.php'><span class='fa fa-fw fa-chart-pie'></span> Estadísticas</a>
        <?php
        }
        ?>
        <a class='menu-item' href='/cambiarpass.php'><span class='fa fa-fw fa-user-lock'></span> Cambiar contraseña </a>
        <?php 
        if ($_SESSION['usuario']->esta_permitido(PERFIL_ADMINISTRADOR, SUBSISTEMA_TODOS)) {
        ?>
        <a class='menu-item' href='/comun/usuarios.php'>
            <span class='fa fa-fw fa-users'></span> Administrar usuarios
        </a>
        <?php
        }
        ?>
        <?php 
        if ($_SESSION['usuario']->esta_permitido(PERFIL_SUPERADMIN, SUBSISTEMA_TODOS)) {
        ?>
        <a class='menu-item' href='/internal/cambiar-subsistema.php'>
            <span class='fa fa-fw fa-exchange-alt'></span> Ir a sistema de <?= $sub_otro ?>
        </a>
        <?php
        }
        ?>
        <a class='menu-item' href='/internal/dologout.php'>
            <span class='fa fa-fw fa-sign-out-alt'></span> Cerrar Sesión
        </a>
    </div>
</header>