<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Registrar nuevo usuario</title>
    <meta name="viewport" content="width=device-width">
    <script src="/libs/3rdparty/chart.umd.min.js"></script>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <?php require('navbar.php') ?>
    <h1 class="titulo">Registrar nuevo usuario</h1>
    <section id="main">
        <div class="form-central">
        <form class="insform">
            <div>
            <label>Nombre de usuario:</label>
            <input type="text" placeholder="Nombre"></input>
            </div>
            <div>
            <label>Cédula:</label>
            <input type="text" placeholder="Cédula"></input>
            </div>
            <div>
            <label>Contraseña:</label>
            <input type="password" placeholder="Contraseña"></input>
            </div>
            <div>
            <label>Confirmar contraseña:</label>
            <input type="password" placeholder="Confirmar contraseña"></input>
            </div>
            <div>
            <label>Pin de recuperación:</label>
            <input type="password" placeholder="Pin"></input>
            </div>
            <div>
            <label>Confirmar pin de recuperación:</label>
            <input type="password" placeholder="Confirmar pin"></input>
            </div>
            <hr/>
            <div>
            
            <label>Perfil:</label>
            <select class="selector">
                <option>Regular</option>
                <option>Administrador</option>
                <option>Solo lectura</option>
            </select>
            </div>
            <div class="element-actions">
                <button>Cancelar</button>
                <button>Registrar</button>
            </div>
        </form>
        </div>
    </section>
</body>
</html>


