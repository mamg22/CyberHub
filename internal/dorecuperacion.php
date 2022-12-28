<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/utils.php';
safe_session_start();

$input_nombre = $_REQUEST['nombre'];
$input_pin = $_REQUEST['pin'];
if (empty($input_nombre) || empty($input_pin)) {
    die("Usuario o pin vacío");
}

try {
    $con = conectar_bd();
} catch (mysqli_sql_exception $e) {
    die("ERROR CRITICO: " . nl2br($e));
}

$stmt = $con->prepare("SELECT id, nombre, pin_recuperacion
                           FROM Vista_usuario
                           WHERE nombre=?");
$stmt->bind_param("s", $input_nombre);
$stmt->execute();
$stmt->bind_result($id, $nombre, $pin);
$stmt->fetch();

if (isset($id) && password_verify($input_pin, $pin)) {
    // Usamos un id temporal para medio loguear al usuario y cambiar su contrasena
    // El id solo es valido en las paginas de cambio de contrasena siguientes
    // Es funcionalmente igual al id regular, pero solo valido en ese contexto
    $_SESSION['recovery_id'] = $id;
    $_SESSION['nombre'] = $nombre;
    header("Location: /cambiarpass.php");
    exit();
} else {
    push_mensaje(new Mensaje(
        "Nombre de usuario o pin incorrecto<br>Por favor, intentelo de nuevo",
        Mensaje::ERROR
    ));
    header("Location: /recuperarpass.php");
}
?>