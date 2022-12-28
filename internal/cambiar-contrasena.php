<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/utils.php';
safe_session_start();

$input_clave = $_REQUEST['clave'];
$input_confclave = $_REQUEST['confclave'];

$hash_clave = password_hash($input_clave, PASSWORD_BCRYPT);
$id = $_SESSION['id'] ?? $_SESSION['recovery_id'];

if (empty($input_clave)) {
    die("Clave vacía");
}

if (isset($_SESSION['recovery_id'])) {
    session_destroy();
}

try {
    $con = conectar_bd();
} catch (mysqli_sql_exception $e) {
    die("ERROR CRITICO: " . nl2br($e));
}

$stmt = $con->prepare("UPDATE Usuario
                       SET clave=?
                       WHERE id=?");
$stmt->bind_param("si", $hash_clave, $id);
$stmt->execute();


if ($stmt->affected_rows === 1) {
    push_mensaje(new Mensaje(
        "Contraseaña cambiada correctamente", 
        Mensaje::OK)
    );
    header("Location: /");
} else { 
    push_mensaje(new Mensaje(
        "Nombre de usuario o pin incorrecto, intentelo de nuevo", 
        Mensaje::ERROR)
    );

}
?>