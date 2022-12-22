<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, inicial-scale=1.0">
    <link rel="stylesheet" href="/styles/style.css">
    <title>Recuperación de contraseña</title>
</head>

<body class="centered-form">
    <div class="page-container">
        <h1 class="titulo">Recuperar contraseña</h1>
        <section id="main-mini">
            <form action='/internal/dorecuperacion.php' method="POST" class="inputs-login">
                <input name='nombre' class="input" type="text" placeholder="Nombre de usuario">
                <input name='pin' class="input" type="password" placeholder="Pin de recuperación">
                <input type='submit' class="boton" value='Recuperar'></input>
            </form>
        </section>
    </div>

</body>

</html>