<?php 
include $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'utils.php'; 
validar_acceso(PERFIL_REGULAR, SUBSISTEMA_CYBER);

$id_objetivo = $_REQUEST['id'] ?? 'nuevo';

if ($id_objetivo == 'nuevo') {
    $titulo = "Registrar nuevo repuesto";
}
else {
    $titulo = "Modificar repuesto";
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
    header("Location: /cyber/repuestos/");
    exit();
}

if ($con) {
    try {
        $stmt = $con->prepare("SELECT id, nombre
        FROM Tipo_repuesto
        ORDER BY id");
        $stmt->execute();
        $tipos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $tipos = array_column($tipos, "nombre", "id");

        if ($id_objetivo != 'nuevo') {
            $stmt = $con->prepare("SELECT
                id, tipo, detalles, cantidad, nombre_tipo
            FROM Vista_repuesto
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
        header("Location: /cyber/repuestos/");
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
            action="/internal/cyber/editar-repuestos.php?<?php 
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
                <label>Tipo:</label>
                <select required name="tipo" class="selector">
                    <option disabled value='' 
                        <?php isset($info) or print('selected') ?>
                    >Elija una opcion</option>
                    <?php
                    foreach ($tipos as $id => $nombre) {
                        if ($id == ($info->tipo ?? null)) {
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
                <label>Cantidad:</label>
                <input name="cantidad" type="number" placeholder="Cantidad"
                    min="0" required step="1"
                    value='<?= $info->cantidad ?? '' ?>'>
                </input>
            </div>
            <div>
                <label>Detalles:</label><br>
                <textarea name="detalles" cols="80" rows="6" placeholder="Detalles o descripción del repuesto"
                maxlength="400" required
                ><?= $info->detalles ?? '' ?></textarea>
            </div>
            <hr/>
            <div>
            
            <div class="element-actions">
                <button type='button' onclick="location.href='/cyber/repuestos/'">Volver atrás</button>
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


