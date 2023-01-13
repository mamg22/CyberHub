<?php 
include $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'utils.php'; 
validar_acceso(PERFIL_REGULAR, SUBSISTEMA_CYBER);

$id_objetivo = $_REQUEST['id'] ?? 'nuevo';

if ($id_objetivo == 'nuevo') {
    $titulo = "Registrar nuevo equipo";
}
else {
    $titulo = "Modificar equipo";
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
    header("Location: /cyber/equipos/");
    exit();
}

if ($con) {
    try {
        $stmt = $con->prepare("SELECT id, nombre_ubicacion AS nombre
        FROM Ubicacion_equipo
        ORDER BY id");
        $stmt->execute();
        $ubicaciones = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $ubicaciones = array_column($ubicaciones, "nombre", "id");

        $stmt = $con->prepare("SELECT id, nombre_estado AS nombre
        FROM Tipo_estado
        ORDER BY id");
        $stmt->execute();
        $estados = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $estados = array_column($estados, "nombre", "id");

        if ($id_objetivo != 'nuevo') {
            $stmt = $con->prepare("SELECT
                id, identificador, desc_hardware, desc_software, ubicacion,
                estado, razon_estado, nombre_ubicacion, nombre_estado
            FROM Vista_equipo
            WHERE id=?");
            $stmt->bind_param("i", $id_objetivo);
            $stmt->execute();
            $info = $stmt->get_result()->fetch_object();
        }
    } catch (mysqli_sql_exception $e) {
        push_mensaje(new Mensaje(
            Mensajes_comun::ERR_CARGANDO_INFO,
            Mensaje::ERROR
        ));
        header("Location: /cyber/equipos/");
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
            action="/internal/cyber/editar-equipos.php?<?php 
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
                <label>Identificador:</label>
                <input name="identificador" type="text" placeholder="Identificador"
                    value='<?= $info->identificador ?? '' ?>'
                    maxlength="30" minlength="1" required>
                </input>
            </div>
            <div>
                <label>Hardware:</label><br>
                <textarea name="desc_hardware" cols="80" rows="6" placeholder="Descripción del hardware"
                required maxlength="500"
                ><?= $info->desc_hardware ?? '' ?></textarea>
            </div>
            <div>
                <label>Software:</label><br>
                <textarea name="desc_software" cols="80" rows="6" placeholder="Descripción del software"
                required maxlength="500"
                ><?= $info->desc_software ?? '' ?></textarea>
            </div>
            <div>
                <label>Ubicación:</label>
                <select required name="ubicacion" class="selector">
                    <option disabled value='' 
                        <?php isset($info) or print('selected') ?>
                    >Elija una opcion</option>
                    <?php
                    foreach ($ubicaciones as $id => $nombre) {
                        if ($id == ($info->ubicacion ?? null)) {
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
                <label>Estado:</label>
                <select required name="estado" class="selector">
                    <option disabled value='' 
                        <?php isset($info) or print('selected') ?>
                    >Elija una opcion</option>
                    <?php
                    foreach ($estados as $id => $nombre) {
                        if ($id == ($info->estado ?? null)) {
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
                <label>Razón de estado:</label><br>
                <textarea name="razon_estado" cols="80" rows="6" placeholder="Descripción del estado del equipo"
                required maxlength="500"
                ><?= $info->razon_estado ?? '' ?></textarea>
            </div>
            <hr/>
            <div>
            
            <div class="element-actions">
                <button type='button' onclick="location.href='/cyber/equipos/'">Volver atrás</button>
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


