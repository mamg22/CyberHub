<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/utils.php';
safe_session_start();

if (isset($_SESSION['recovery_id'])) {
    unset($_SESSION['recovery_id']);
    unset($_SESSION['recovery_nombre']);
}

if (isset($_SESSION['usuario'])) {
    // Usuario logueado, enviar al menu principal
    $sub_actual = $_SESSION['subsistema_actual'];
    if ($sub_actual === SUBSISTEMA_CYBER) {
        header("Location: /cyber/menu-principal.php");
    }
    else {
        header("Location: /tecnico/menu-principal.php");
    }
}
else {
    // Usuario no logueado, enviar al login
    header("Location: /login.php");
}
exit();
?>