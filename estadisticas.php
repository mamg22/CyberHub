<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Estadísticas: Cyber</title>
    <meta name="viewport" content="width=device-width">
    <script src="/libs/3rdparty/chart.umd.min.js"></script>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <?php require('navbar.php') ?>
    <h1 class="titulo">Estadísticas: Cyber</h1>
    <section id="main">
        <div class="canvas-holder">
            <canvas id="chart-area" />
        </div>
        <div class="canvas-holder">
            <canvas height="300" id="chart-area2" />
        </div>
    </section>
    <script>
    Chart.defaults.color = 'black';
    var config = {
        type: 'pie',
        data: {
            datasets: [{
                data: [
                    13,
                    4,
                    3,
                    1,
                    5
                ],
                backgroundColor: [
                    '#ff0000',
                    '#33ff11',
                    '#ff00ff',
                    '#99cc00',
                    '#0000dd',
                ],
                label: 'Equipos'
            }],
            labels: [
                "Activo",
                "Inactivo",
                "En reparación",
                "En almacén",
                "Por reparar"
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: "right"
                },
                title: {
                    display: true,
                    text: 'Equipos computacionales',
                    padding: {
                        top: 10,
                        bottom: 30
                    },
                    font: {
                        size: 15
                    }
                }
            }
        }
    };

    var config2 = {
        type: 'bar',
        data: {
            datasets: [{
                data: [
                    3,
                    10,
                    10,
                    4,
                ],
                backgroundColor: [
                    '#7777ff',
                    '#2222ff',
                    '#0000cc',
                    '#000077',
                ],
                label: 'Equipos'
            }],
            labels: [
                "Almacén",
                "Sala 1",
                "Sala 2",
                "Oficina"
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    /*position: "right"*/
                },
                title: {
                    display: true,
                    text: 'Ubicación de equipos',
                    padding: {
                        top: 10,
                        bottom: 30
                    },
                    font: {
                        size: 15
                    }
                }
            }
        }
    };

    window.onload = function() {
        var ctx = document.getElementById("chart-area").getContext("2d");
        window.myPie = new Chart(ctx, config);
        var ctx2 = document.getElementById("chart-area2").getContext("2d");
        window.myBar = new Chart(ctx2, config2);
    };
    </script>
</body>
</html>
