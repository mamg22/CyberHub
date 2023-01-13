<?php 
include $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'utils.php'; 
validar_acceso(PERFIL_REGULAR, SUBSISTEMA_SERVICIO);

$id_objetivo = $_REQUEST['id'] ?? 'nuevo';

if ($id_objetivo == 'nuevo') {
    $titulo = "Registrar nuevo trabajo";
}
else {
    $titulo = "Modificar trabajo";
}

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
    header("Location: /tecnico/trabajos");
    exit();
}

if ($con) {
    try {
        // El nombre y cedula se presentan en formato "[CEDULA] NOMBRE"
        $stmt = $con->prepare("SELECT id, CONCAT('[', cedula, '] ', nombre) AS nombre
        FROM Cliente
        ORDER BY lower(cedula)");
        $stmt->execute();
        $clientes = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $clientes = array_column($clientes, "nombre", "id");

        $stmt = $con->prepare("SELECT id, nombre
        FROM Estado_trabajo
        ORDER BY id");
        $stmt->execute();
        $estados = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $estados = array_column($estados, "nombre", "id");

        if ($id_objetivo != 'nuevo') {
            $stmt = $con->prepare("SELECT
                id, descripcion_equipo, problema, identificador,
                monto_total, monto_cancelado, estado_t,
                cliente, nombre_estado_t
            FROM Vista_trabajos
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
        header("Location: /tecnico/trabajos");
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
    <script type="text/javascript">
        function set_blocker(state) {
            var blocker = document.getElementById("blocker");
            if (state) {
                blocker.classList.add("visible");
            }
            else {
                blocker.classList.remove("visible");
            }
        }
        function setup_reg_handler(ev) {
            var reg_a = document.getElementById('reg-cliente');
            reg_a.addEventListener('click', function() {
                var w = window.open("/tecnico/clientes/cliente.php?id=nuevo&modo_ventana=popup");
                set_blocker(true);
                var timer = setInterval(function() {
                    if (w.closed) {
                        clearInterval(timer);
                        set_blocker(false);
                        location.reload();
                    }
                }, 250)
            });

            var blocker = document.getElementById("blocker");

            // Desactivar cualquier click mientras el bloqueador este visible
            blocker.addEventListener('click', function (ev) {
                ev.preventDefault();
                return false;
            });
        }

        window.addEventListener('load', setup_reg_handler);
    </script>
</head>
<body>
    <?php require('libs/navbar.php') ?>
    <h1 class="titulo"><?= $titulo ?></h1>
    <section id="main">
        <div class="form-central">
        <form class="insform" method="POST" 
            action="/internal/tecnico/editar-trabajos.php?<?php 
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
            <input type="hidden" name="id" 
                value="<?= $info->id ?? 'nuevo' ?>">
            <div>
                <label>Cliente:</label>
                <select required name="cliente" class="selector">
                    <option disabled value='' 
                        <?php isset($info) or print('selected') ?>
                    >Elija una opcion</option>
                    <?php
                    foreach ($clientes as $id => $nombre) {
                        if ($id == ($info->cliente ?? null)) {
                            print("<option value='$id' selected>$nombre</option>");
                        }
                        else {
                            print("<option value='$id'>$nombre</option>");
                        }
                    }
                    ?>
                </select>
            </div>
            <div>
                <a class="buttonlink" id="reg-cliente" href="#">Registrar nuevo cliente</a>
            </div>
            <div>
                <label>Identificador:</label>
                <input name="identificador" type="text" placeholder="Identificador del equipo"
                    required maxlength="30"
                    value='<?= $info->identificador ?? '' ?>'>
                </input>
            </div>
            <div>
                <label>Descripción del equipo:</label><br>
                <textarea name="descripcion_equipo" cols="80" rows="6" placeholder="Descripción del equipo"
                required maxlength="150"
                ><?= $info->descripcion_equipo ?? '' ?></textarea>
            </div>
            <div>
                <label>Problema:</label><br>
                <textarea name="problema" cols="80" rows="6" placeholder="Problema que presenta el equipo"
                required maxlength="500"
                ><?= $info->problema ?? '' ?></textarea>
            </div>
            <div>
                <label>Monto total:</label>
                <input name="monto_total" type="number" placeholder="Monto total"
                    min="0" step="0.01" required
                    value='<?= $info->monto_total ?? '' ?>'>
                </input>
            </div>
            <div>
                <label>Monto cancelado:</label>
                <input name="monto_cancelado" type="number" placeholder="Monto cancelado"
                    min="0" step="0.01" required
                    value='<?= $info->monto_cancelado ?? '' ?>'>
                </input>
            </div>
            <div>
                <label>Estado del trabajo:</label>
                <select required name="estado_t" class="selector">
                    <option disabled value='' 
                        <?php isset($info) or print('selected') ?>
                    >Elija una opcion</option>
                    <?php
                    foreach ($estados as $id => $nombre) {
                        if ($id == ($info->estado_t ?? null)) {
                            print("<option value='$id' selected>$nombre</option>");
                        }
                        else {
                            print("<option value='$id'>$nombre</option>");
                        }
                    }
                    ?>
                </select>
            </div>
            <hr/>
            
            <div class="element-actions">
                <button type='button' onclick="location.href='/tecnico/trabajo'">Volver atrás</button>
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
    <div id='blocker'>
        <p>Esta pestaña está esperando a que se complete o cancele el registro del nuevo cliente.<br><br>
           Puede completar el formulario, cancelarlo o cerrar la pestaña para continuar.
        </p>
    </div>
</body>
</html>


