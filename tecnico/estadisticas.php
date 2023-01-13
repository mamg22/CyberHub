<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'utils.php'; 
validar_acceso(PERFIL_SOLOLECTURA, SUBSISTEMA_SERVICIO);

$con = null;
$info_cargada = false;
try {
    $con = conectar_bd();
} catch (mysqli_sql_exception $e) {
    push_mensaje(new Mensaje(
        Mensajes_comun::ERR_CONECTANDO_BD,
        Mensaje::ERROR
    ));
    header("Location: /tecnico/menu-principal.php");
    exit();
}

if ($con) {
    try {
        $stmt = $con->prepare("SELECT nombre_estado_t, count(id) AS total
            FROM Vista_trabajos
            GROUP BY estado_t");
        $stmt->execute();
        $trabajos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $stmt = $con->prepare("SELECT 
                sum(monto_cancelado) AS total_cancelado,
                sum(monto_total) AS total_completo,
                sum(monto_total - monto_cancelado) AS total_por_cancelar 
            FROM Vista_trabajos");
        $stmt->execute();
        $montos = $stmt->get_result()->fetch_object();

    } catch (mysqli_sql_exception $e) {
        error_log($e);
        push_mensaje(new Mensaje(
            Mensajes_comun::ERR_CARGANDO_INFO,
            Mensaje::ERROR
        ));
        header("Location: /tecnico/menu-principal.php");
        exit();
    }
}

if (empty($trabajos)) {
    push_mensaje(new Mensaje(
        "No hay trabajos registrados en el sistema, las estadísticas de trabajos no tendrán información.",
        Mensaje::WARN
    ));
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include('libs/head-common.php') ?>
    <?= inyectar_mensajes() ?>

    <script src="/libs/3rdparty/chart.umd.min.js"></script>

    <title>Estadísticas: Servicio Técnico</title>
</head>
<body>
    <?php require('libs/navbar.php') ?>
    <h1 class="titulo">Estadísticas: Servicio Técnico</h1>
    <section id="main" class='stats'>
        <div class="element-container">
        <div class="element stats">
            <canvas id="chart-area1"></canvas>
        </div>
        <div class="element stats">
            <table id='montos'>
                <caption>
                    Montos totales por trabajos
                </caption>
                <tbody>
                    <tr id='cancelados'>
                        <td class='descripcion'>Cancelado</td>
                        <td class='cantidad'><?= $montos->total_cancelado ?? '0.00' ?></td>
                    </tr>
                    <tr id='por-cancelar'>
                        <td class='descripcion'>Por cancelar</td>
                        <td class='cantidad'><?= $montos->total_por_cancelar ?? '0.00' ?></td>
                    </tr>
                    <tr id='totales'>
                        <td class='descripcion'>Total</td>
                        <td class='cantidad'><?= $montos->total_completo ?? '0.00' ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    </section>
    <script>
    Chart.defaults.color = 'black';
    Chart.defaults.responsive = true;
    Chart.defaults.maintainAspectRatio = false;

    var config1 = {
        type: 'pie',
        data: {
            datasets: [{
                data: <?= json_encode(array_column(array_values($trabajos), "total")) ?>,
                label: 'Trabajos'
            }],
            labels: <?= json_encode(array_column(array_values($trabajos), "nombre_estado_t")) ?>
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Estado actual de trabajos',
                    font: {
                        size: 18
                    }
                }
            }
        }
    };

    window.onload = function() {
        var ctx1 = document.getElementById("chart-area1").getContext("2d");
        window.myPie1 = new Chart(ctx1, config1);
    };
    </script>
    <div id='popup-container'></div>
</body>
</html>
