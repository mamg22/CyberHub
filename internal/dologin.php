<?php
include $_SERVER['DOCUMENT_ROOT'] . '/utils.php';

$input_nombre = $_REQUEST['nombre'];
$input_clave = $_REQUEST['clave'];
if (empty($input_nombre) || empty($input_clave)) {
    die("Usuario o clave vacío");
}

try {
    $con = conectar_bd();
}
catch (mysqli_sql_exception $e) {
    die("ERROR CRITICO: " . nl2br($e));
}

$stmt = $con->prepare("SELECT id, nombre, clave, subsistema, perfil
                           FROM Vista_usuario
                           WHERE nombre=?");
$stmt->bind_param("s", $input_nombre);
$stmt->execute();
$stmt->bind_result($id, $nombre, $clave, $subsistema, $perfil);
$stmt->fetch();

if (isset($id) && password_verify($input_clave, $clave)) {
    safe_session_start();
    $_SESSION['id'] = $id;
    $_SESSION['nombre'] = $nombre;
    $_SESSION['subsistema'] = $subsistema;
    $_SESSION['perfil'] = $perfil;

    switch ($subsistema) {
        case 1:
        case 2:
            $_SESSION['subsistema_actual'] = SUBSISTEMA_CYBER;
            header("Location: /cyber/menu-principal.php");
            break;
        case 3:
            $_SESSION['subsistema_actual'] = SUBSISTEMA_SERVICIO;
            header("Location: /tecnico/menu-principal.php");
            break;
    }
    exit();
}
else {
?>
<html>
<head></head>
<body>
    <script>
        alert("Nombre de usuario o contraseña incorrecto\nPor favor, intentelo de nuevo");
    window.history.back()
    </script>
</body>
</html>
<?php
}
?>