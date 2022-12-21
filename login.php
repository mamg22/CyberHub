<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE-edge">
<meta name="viewport" content="width=device-width, inicial-scale=1.0">
<link rel="stylesheet" href="/styles/style.css">
<title>Iniciar sesión</title>
</head>

<body class="centered-form">
    <div class="page-container">
    <h1 class="titulo">Iniciar sesión</h1>
        <section id="main-mini">
        <form class="inputs-login" action='/internal/dologin.php' method='POST'>
            <input autofocus name='nombre' class="input" type="text" placeholder="Nombre de usuario">
            <input name='clave' class="input" type="password" placeholder="Contraseña">
            <input type='submit' class="boton" value='Ingresar'></input>
            <p><a href='/recuperarpass.php' class='link'>¿Olvidaste la Contraseña? Click Aquí</a></p>
        </form>
        </section>
    </div>
</body>
</html>
