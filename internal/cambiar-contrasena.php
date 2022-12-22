<?php
include $_SERVER['DOCUMENT_ROOT'] . '/utils.php';

$input_clave = $_REQUEST['clave'];
$input_confclave = $_REQUEST['confclave'];
$input_recuperacion = $_REQUEST['recuperacion'];
if (empty($input_clave)) {
    die("Clave vacía");
}

$hash_clave = password_hash($input_clave, PASSWORD_BCRYPT);
$id = $_SESSION['id'];

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
// TODO: Como verificar el exito?
$stmt->bind_result($id, $nombre, $pin);
$stmt->fetch();

if (isset($id) && password_verify($input_pin, $pin)) {
    safe_session_start();
    $_SESSION['recuperacion'] = 1;
    $_SESSION['id'] = $id;
    $_SESSION['nombre'] = $nombre;
    header("Location: /cambiarpass.php");
    exit();
} else {
?>
    <html>

    <head></head>

    <body>
        <script>
            alert("Nombre de usuario o pin incorrecto\nPor favor, intentelo de nuevo");
            window.history.back()
        </script>
    </body>

    </html>
<?php
}
?>