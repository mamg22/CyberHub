<?php 
include $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'utils.php'; 

$id_objetivo = $_REQUEST['id'] ?? 'nuevo';

if ($id_objetivo == 'nuevo') {
    $titulo = "Registrar nuevo usuario";
}
else {
    $titulo = "Modificar usuario";
}

$con = null;
$info_cargada = false;
try {
    $con = conectar_bd();
} catch (mysqli_sql_exception $e) {
    push_mensaje(new Mensaje(
        Mensajes_comun::ERR_CONECTANDO_BD,
        Mensaje::ERROR
    ));
    header("Location: /comun/usuarios.php");
    exit();
}

if ($con) {
    try {
        $stmt = $con->prepare("SELECT nivel, nombre
        FROM Perfil_usuario
        WHERE nivel>10
        ORDER BY nivel DESC");
        $stmt->execute();
        $perfiles = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $perfiles = array_column($perfiles, "nombre", "nivel");

        if ($id_objetivo != 'nuevo') {
            $stmt = $con->prepare("SELECT id, nombre, cedula, perfil
            FROM Vista_usuario
            WHERE id=?");
            $stmt->bind_param("i", $id_objetivo);
            $stmt->execute();
            $info_usuario = $stmt->get_result()->fetch_object();
        }
    } catch (mysqli_sql_exception $e) {
        push_mensaje(new Mensaje(
            Mensajes_comun::ERR_CARGANDO_INFO,
            Mensaje::ERROR
        ));
        header("Location: /comun/usuarios.php");
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include('libs/head-common.php') ?>
    <?= inyectar_mensajes() ?>

    <script>
        function validar_confimacion_clave(ev) {
            var clave = document.querySelector('*[name="clave"]');
            var confirmacion = document.querySelector('*[name="confclave"]');
            if (clave.value !== confirmacion.value) {
                clave.setCustomValidity(
                    "La contraseña y la confirmación de la contraseña no coinciden. Por favor, introduzcala de nuevo.");
            }
            else {
                clave.setCustomValidity('');
            }
        }

        function validar_confimacion_pin(ev) {
            var pin = document.querySelector('*[name="pin"]');
            var confirmacion = document.querySelector('*[name="confpin"]');
            if (pin.value !== confirmacion.value) {
                pin.setCustomValidity(
                    "El pin y la confirmación del pin no coinciden. Por favor, introduzcalo de nuevo.");
            }
            else {
                pin.setCustomValidity('');
            }
        }

        function setup_validacion() {
            var clave = document.querySelector('*[name="clave"]');
            var confclave = document.querySelector('*[name="confclave"]');
            clave.addEventListener('input', validar_confimacion_clave);
            confclave.addEventListener('input', validar_confimacion_clave);

            var pin = document.querySelector('*[name="pin"]');
            var confpin = document.querySelector('*[name="confpin"]');
            pin.addEventListener('input', validar_confimacion_pin);
            confpin.addEventListener('input', validar_confimacion_pin);
        }

        window.addEventListener('DOMContentLoaded', setup_validacion)
    </script>
    <title><?= $titulo ?></title>
</head>
<body>
    <?php require('libs/navbar.php') ?>
    <h1 class="titulo"><?= $titulo ?></h1>
    <section id="main">
        <div class="form-central">
        <form class="insform" method="POST" 
            action="/internal/comun/editar-usuarios.php?<?php 
                if ($id_objetivo == 'nuevo') {
                    $modo = 'insertar';
                }
                else {
                    $modo = 'actualizar';
                }

                print(http_build_query([
                    "modo" => $modo,
                    "id" => $id_objetivo,
                ]))
            ?>">
            <?= help_icon("El formulario no le dejará introducir más texto una vez alcance el límite de tamaño.") ?>
            <input type="hidden" name="id" 
                value="<?= htmlentities($info_usuario->id ?? 'nuevo') ?>">
            <div>
            <label for="nombre">Nombre de usuario: <?= help_icon("El nombre de usuario solo puede contener carácateres alfanuméricos (0-9, A-Z, a-z), el guión bajo (_) y el guión (-)")?></label>
            <input name='nombre' type="text" placeholder="Nombre"
                value='<?= $info_usuario->nombre ?? '' ?>' 
                maxlength="25" minlength="1" required pattern='[0-9a-zA-Z_-]+'
                title="El nombre de usuario solo puede contener carácateres alfanuméricos (0-9, A-Z, a-z), el guión bajo (_) y el guión (-)">
            </div>
            <div>
            <label for="cedula">Cédula:</label>
            <input name='cedula' type="text" placeholder="Cédula"
                value='<?= $info_usuario->cedula ?? '' ?>'
                maxlength="15" minlength="1" required>
            </input>
            </div>
            <?php if ($id_objetivo == 'nuevo') { ?>
            <div>
            <label for="clave">Contraseña:
                <?= help_icon("La contraseña debe contener al menos 8 caracteres, incluyendo una mayúscula, una minúscula y un número") ?>
            </label>
            <input name='clave' type="password" placeholder="Contraseña"
                minlength="8" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required
                title="La contraseña debe contener al menos 8 caracteres, incluyendo una mayúscula, una minúscula y un número">
            </div>
            <div>
            <label for="confclave">Confirmar contraseña:</label>
            <input name='confclave' type="password" placeholder="Confirmar contraseña"
                minlength="8" required>
            </div>
            <div>
            <label for="pin">Pin de recuperación:
                <?= help_icon("El pin debe contener sólo numeros, y se requieren al menos 10 números para un pin válido") ?>
            </label>
            <input name='pin' type="password" placeholder="Pin"
                minlength="10" pattern="[0-9]{10,}" required
                title="El pin debe contener sólo numeros, y se requieren al menos 10 números para un pin válido">
            </div>
            <div>
            <label for="confpin">Confirmar pin de recuperación:</label>
            <input name='confpin' type="password" placeholder="Confirmar pin"
                minlength="10" required>
            </div>
            <?php } ?>
            <hr/>
            <div>
            
            <label for="perfil">Perfil:</label>
            <select required name='perfil' class="selector">
                <option disabled value='' 
                    <?php isset($info_usuario) or print('selected') ?>
                >Elija una opcion</option>
                <?php
                foreach ($perfiles as $nivel => $nombre) {
                    if ($nivel == ($info_usuario->perfil ?? null)) {
                        print("<option value='$nivel' selected>$nombre</option>");
                    }
                    else {
                        print("<option value='$nivel'>$nombre</option>");
                    }
                }
                ?>
            </select>
            </div>
            <input type="hidden" name="subsistema" value="<?= $_SESSION['subsistema_actual']?>">
            <div class="element-actions">
                <button type='button' onclick="location.href='/comun/usuarios.php'">Volver atrás</button>
                <button type='reset'>Deshacer cambios</button>
                <button type='submit'>
                    <?php 
                    if ($id_objetivo == 'nuevo') {
                        echo "Registrar";
                    }
                    else {
                        echo "Actualizar";
                    }
                    ?>
                </button>
            </div>
        </form>
        </div>
    </section>
    <div id='popup-container'></div>
</body>
</html>


