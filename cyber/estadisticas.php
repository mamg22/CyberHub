<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'utils.php'; 
validar_acceso(PERFIL_SOLOLECTURA, SUBSISTEMA_CYBER);

$con = null;
$info_cargada = false;
try {
    $con = conectar_bd();
} catch (mysqli_sql_exception $e) {
    push_mensaje(new Mensaje(
        Mensajes_comun::ERR_CONECTANDO_BD,
        Mensaje::ERROR
    ));
    header("Location: /cyber/menu-principal.php");
    exit();
}

if ($con) {
    try {
        $stmt = $con->prepare("SELECT nombre_ubicacion, count(id) AS total
            FROM Vista_equipo
            GROUP BY ubicacion");
        $stmt->execute();
        $equipos_por_ubicacion = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $stmt = $con->prepare("SELECT nombre_estado, count(id) AS total
            FROM Vista_equipo
            GROUP BY estado");
        $stmt->execute();
        $equipos_por_estado = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $stmt = $con->prepare("SELECT nombre_tipo, sum(cantidad) AS total, count(DISTINCT detalles) AS variedades
            FROM Vista_repuesto
            GROUP BY tipo");
        $stmt->execute();
        $repuestos_por_tipo = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


    } catch (mysqli_sql_exception $e) {
        error_log($e);
        push_mensaje(new Mensaje(
            Mensajes_comun::ERR_CARGANDO_INFO,
            Mensaje::ERROR
        ));
        header("Location: /cyber/menu-principal.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include('libs/head-common.php') ?>
    <?= inyectar_mensajes() ?>

    <script src="/libs/3rdparty/chart.umd.min.js"></script>

    <title>Estadísticas: Cyber</title>
</head>
<body>
    <?php require('libs/navbar.php') ?>
    <h1 class="titulo">Estadísticas: Cyber</h1>
    <section id="main" class='stats'>
        <div class="element-container">
        <div class="element stats">
            <canvas id="chart-area1"></canvas>
        </div>
        <div class="element stats">
            <canvas id="chart-area2"></canvas>
        </div>
        <div class="element stats">
            <canvas id="chart-area3"></canvas>
        </div>
        <div class="element stats">
            <canvas id="chart-area4"></canvas>
        </div>
    </div>
    </section>
    <script>
    Chart.defaults.color = 'black';
    Chart.defaults.responsive = true;
    Chart.defaults.maintainAspectRatio = false;

    var config1 = {
        type: 'bar',
        data: {
            datasets: [{
                data: <?= json_encode(array_column(array_values($equipos_por_ubicacion), "total")) ?>,
                label: 'Equipos'
            }],
            labels: <?= json_encode(array_column(array_values($equipos_por_ubicacion), "nombre_ubicacion")) ?>
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Equipos computacionales por ubicación',
                    font: {
                        size: 18
                    }
                }
            }
        }
    };

    var config2 = {
        type: 'bar',
        data: <?= json_encode([
            "datasets" => [[
                    "data" => array_column(array_values($equipos_por_estado), "total"),
                    "label" => "Equipos",
                ]],
            "labels" => array_column(array_values($equipos_por_estado), "nombre_estado"),
        ]) ?>,
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Estado de equipos',
                    font: {
                        size: 18
                    }
                }
            }
        }
    };

    var config3 = {
        type: 'pie',
        data: <?= json_encode([
            "datasets" => [[
                    "data" => array_column(array_values($repuestos_por_tipo), "total"),
                    "label" => "Repuestos",
                ]],
            "labels" => array_column(array_values($repuestos_por_tipo), "nombre_tipo"),
        ]) ?>,
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Repuestos por tipo',
                    font: {
                        size: 18
                    }
                }
            }
        }
    };




    var config4 = {
        type: 'pie',
        data: <?= json_encode([
            "datasets" => [[
                    "data" => array_column(array_values($repuestos_por_tipo), "variedades"),
                    "label" => "Tipos distintos de repuesto",
                ]],
            "labels" => array_column(array_values($repuestos_por_tipo), "nombre_tipo"),
        ]) ?>,
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Variedades de repuestos',
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
        var ctx2 = document.getElementById("chart-area2").getContext("2d");
        window.myPie2 = new Chart(ctx2, config2);
        var ctx3 = document.getElementById("chart-area3").getContext("2d");
        window.myPie3 = new Chart(ctx3, config3);
        var ctx4 = document.getElementById("chart-area4").getContext("2d");
        window.myPie4 = new Chart(ctx4, config4);
    };
    </script>
    <div id='popup-container'></div>
</body>
</html>
