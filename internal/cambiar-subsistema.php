<?php
include_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'utils.php'; 
safe_session_start();

$subactual = $_SESSION['subsistema_actual'];

if (perfil_permitido($_SESSION['perfil'], PERFIL_SUPERADMIN)) {

    if ($subactual === SUBSISTEMA_CYBER) {
        $_SESSION['subsistema_actual'] = SUBSISTEMA_SERVICIO;
        header("Location: /tecnico/menu-principal.php");
    }
    else {
        $_SESSION['subsistema_actual'] = SUBSISTEMA_CYBER;
        header("Location: /cyber/menu-principal.php");
    }
    exit();
}
else {
    push_mensaje(new Mensaje(
        "Usuario no autorizado para cambiar de subsistema",
        Mensaje::ERROR
    ));
    if ($subactual === SUBSISTEMA_CYBER) {
        header("Location: /cyber/menu-principal.php");
    }
    else {
        header("Location: /servicio/menu-principal.php");
    }
    exit();
}
?>