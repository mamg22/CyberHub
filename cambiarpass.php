<?php 
include $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'utils.php';
safe_session_start();

$recuperacion = $_SESSION['recuperacion'] ?? 0;
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE-edge">
<meta name="viewport" content="width=device-width, inicial-scale=1.0">
<link rel="stylesheet" href="/styles/style.css">
<title>Cambiar contraseña para <?= $_SESSION['nombre'] ?></title>
</head>

<body class="centered-form">
        <div class="page-container">
            <h1 class="titulo">Cambiar contraseña para <?= $_SESSION['nombre'] ?></h1>

          <section id="main-mini">
          <form class="inputs-login">
                <input name='clave' class="input" type="password" placeholder="Nueva contraseña">
                <input name='confclave' class="input" type="password" placeholder="Confirmar nueva contraseña">
                <input type='submit' class="boton" value='Cambiar contraseña'>
                <input type='hidden' name='recuperacion' value='<?= $recuperacion ?>'>
            </form>
            </section>
        </div>

</body>
</html>


