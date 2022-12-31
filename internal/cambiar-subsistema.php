<?php
include_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'utils.php'; 
safe_session_start();
validar_acceso(PERFIL_SUPERADMIN, SUBSISTEMA_TODOS);

$subactual = $_SESSION['subsistema_actual'];

if ($subactual === SUBSISTEMA_CYBER) {
    $_SESSION['subsistema_actual'] = SUBSISTEMA_SERVICIO;
}
else {
    $_SESSION['subsistema_actual'] = SUBSISTEMA_CYBER;
}
header("Location: /");
exit();

?>