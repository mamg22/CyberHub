<?php 
include $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'utils.php'; 
validar_acceso(PERFIL_REGULAR, SUBSISTEMA_SERVICIO);

$id_objetivo = $_REQUEST['id'] ?? 'nuevo';

if ($id_objetivo == 'nuevo') {
    $titulo = "Registrar nuevo cliente";
}
else {
    $titulo = "Modificar cliente";
}

$modo_ventana = $_REQUEST['modo_ventana'] ?? 'normal';

$con = null;
$info_cargada = false;
try {
    $con = conectar_bd();
} catch (mysqli_sql_exception $e) {
    error_log($e);
    push_mensaje(new Mensaje(
        Mensajes_comun::ERR_CONECTANDO_BD,
        Mensaje::ERROR
    ));
    header("Location: /tecnico/clientes");
    exit();
}

if ($con) {
    try {
        if ($id_objetivo != 'nuevo') {
            $stmt = $con->prepare("SELECT
                id, nombre, telefono_contacto, cedula
            FROM Cliente
            WHERE id=?");
            $stmt->bind_param("i", $id_objetivo);
            $stmt->execute();
            $info = $stmt->get_result()->fetch_object();
        }
    } catch (mysqli_sql_exception $e) {
        error_log($e);
        push_mensaje(new Mensaje(
            Mensajes_comun::ERR_CARGANDO_INFO,
            Mensaje::ERROR
        ));
        header("Location: /tecnico/clientes");
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include('libs/head-common.php') ?>
    <?= inyectar_mensajes() ?>

    <title><?= $titulo ?></title>
</head>
<body>
    <?php require('libs/navbar.php') ?>
    <h1 class="titulo"><?= $titulo ?></h1>
    <section id="main">
        <div class="form-central">
        <form class="insform" method="POST" 
            action="/internal/tecnico/editar-clientes.php?<?php 
                if ($id_objetivo == 'nuevo') {
                    $modo = 'insertar';
                    if ($modo_ventana == 'popup') {
                        $modo .= '-popup';
                    }
                }
                else {
                    $modo = 'actualizar';
                }


                print(http_build_query([
                    "modo" => $modo,
                    "id" => $id_objetivo,
                ]))
            ?>">
            <input type="hidden" name="id" 
                value="<?= $info->id ?? 'nuevo' ?>">
            <div>
                <label>Nombre:</label>
                <input name="nombre" type="text" placeholder="Nombre"
                    required maxlength="75"
                    value='<?= $info->nombre ?? '' ?>'>
                </input>
            </div>
            <div>
                <label>Teléfono de contacto:</label>
                <input name="telefono_contacto" type="text" placeholder="Teléfono de contacto"
                    required maxlength="15"
                    value='<?= $info->telefono_contacto ?? '' ?>'>
                </input>
            </div>
            <div>
                <label>Cédula:</label>
                <input name="cedula" type="text" placeholder="Cédula"
                    value='<?= $info->cedula ?? '' ?>'>
                </input>
            </div>
            <hr/>
            
            <div class="element-actions">
                <?php if ($modo_ventana == 'popup') { ?>
                    <button type='button' onclick="window.close()">Cerrar</button>
                <?php } else { ?>
                    <button type='button' onclick="location.href='/tecnico/clientes/'">Volver atrás</button>
                <?php } ?>
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
            <?php if ($id_objetivo != 'nuevo') { ?>
            <div class="element-actions">
                <button class='dangerous needs-confirm' type='submit' formaction="/internal/tecnico/editar-clientes.php?<?php
                print(http_build_query([
                    "modo" => "eliminar-totalmente",
                    "id" => $id_objetivo,
                ]))
                ?>">Eliminar totalmente
                </button>
            </div>
            <span class='help-item fa fa-question-circle fa-lg' 
                help-content='La opción "Eliminar totalmente" eliminará al cliente y todos los trabajos asignados
                              por éste. Usar con precaución.'></span>
            <?php } ?>
        </form>
        </div>
    </section>
    <div id='popup-container'></div>
</body>
</html>


