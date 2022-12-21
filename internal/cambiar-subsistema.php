<?php
include $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'utils.php'; 
safe_session_start();

if (perfil_permitido($_SESSION['perfil'], PERFIL_SUPERADMIN)) {
    $subactual = $_SESSION['subsistema_actual'];

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
?>
<html>
<head></head>
<body>
    <script type="text/javascript">
        alert("Error: Usuario no autorizado para cambiar de subsistema");
        window.history.back();
    </script>
</body>
</html>
<?php
}
?>