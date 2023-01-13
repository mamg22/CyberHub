<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/utils.php';


$input_clave = $_REQUEST['clave'];
$input_confclave = $_REQUEST['confclave'];

$hash_clave = password_hash($input_clave, PASSWORD_BCRYPT);
$id = $_SESSION['recovery_id'] ?? $_SESSION['usuario']->id();

if (empty($input_clave)) {
    push_mensaje(new Mensaje(
        Mensajes_comun::ERR_INCOMPLETO,
        Mensaje::ERROR
    ));
    header("Location: /cambiarpass.php");
    exit();
}


try {
    $con = conectar_bd();
} catch (mysqli_sql_exception $e) {
    push_mensaje(new Mensaje(
        Mensajes_comun::ERR_CONECTANDO_BD,
        Mensaje::ERROR
    ));
    header("Location: /");
    exit();
}

try {
    $stmt = $con->prepare("UPDATE Usuario
    SET clave=?
    WHERE id=?");
    $stmt->bind_param("si", $hash_clave, $id);
    $stmt->execute();
} catch (mysqli_sql_exception $e) {
    push_mensaje(new Mensaje(
        "Ha ocurrido un error al cambiar la contraseña. Por favor, intentelo de nuevo.<br>" .
        "Si el problema persiste, contacte al administrador.",
        Mensaje::ERROR
    ));
    header("Location: /cambiarpass.php");
    exit();
}

if (isset($_SESSION['recovery_id'])) {
    session_unset();
}

if ($stmt->affected_rows === 1) {
    push_mensaje(new Mensaje(
        "Contraseña cambiada correctamente", 
        Mensaje::OK)
    );
    header("Location: /");
} else { 
    push_mensaje(new Mensaje(
        "Nombre de usuario o pin incorrecto, intentelo de nuevo", 
        Mensaje::ERROR)
    );
    header("Location: /cambiarpass.php");

}
?>