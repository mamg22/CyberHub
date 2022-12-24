<?php
include $_SERVER['DOCUMENT_ROOT'] . '/utils.php';
safe_session_start();

if (isset($_REQUEST['success'])) {
    $s = "s=1";
} else {
    $s = "s=0";
}

if (isset($_SESSION['id'])) {
    // Usuario logueado, enviar al menu principal
    $sub_actual = $_SESSION['subsistema_actual'];
    if ($sub_actual === SUBSISTEMA_CYBER) {
        header("Location: /cyber/menu-principal.php?$s");
    }
    else {
        header("Location: /tecnico/menu-principal.php?$s");
    }
}
else {
    // Usuario no logueado, enviar al login
    header("Location: /login.php?$s");
}
exit();
?>