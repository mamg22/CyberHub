<?php
include $_SERVER['DOCUMENT_ROOT'] . '/utils.php';

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