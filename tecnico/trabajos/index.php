<?php
include $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'utils.php';
validar_acceso(PERFIL_SOLOLECTURA, SUBSISTEMA_SERVICIO);

$pagina = (int)($_REQUEST['pagina'] ?? 1);
$offset = $pagina - 1;
$item_offset = $offset * ITEMS_POR_PAGINA;

$con = null;
$info_cargada = false;
try {
    $con = conectar_bd();
} catch (mysqli_sql_exception $e) {
    push_mensaje(new Mensaje(
        Mensajes_comun::ERR_CONECTANDO_BD,
        Mensaje::ERROR
    ));
}

$total = 0;
if ($con) {
    try {
        // Datos, datos, datos y más datos
        $stmt = $con->prepare("SELECT
                id, descripcion_equipo, problema, identificador,
                monto_total, monto_cancelado, estado_t,
                cliente, nombre_estado_t,
                nombre_cliente, telefono_cliente, cedula_cliente
        FROM Vista_trabajos
        ORDER BY lower(identificador)
        LIMIT ?, ?");
        $stmt->bind_param("ii", $item_offset, $ITEMS_POR_PAGINA);
        $stmt->execute();
        $info = $stmt->get_result();

        $stmt = $con->prepare("SELECT count(id) as total
        FROM Vista_trabajos
        ORDER BY lower(identificador)");
        $stmt->execute();
        $total = $stmt->get_result()->fetch_object()->total;

        $info_cargada = true;
    } catch (mysqli_sql_exception $e) {
        error_log($e);
        push_mensaje(new Mensaje(
            Mensajes_comun::ERR_CARGANDO_INFO,
            Mensaje::ERROR
        ));
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include('libs/head-common.php') ?>
    <?= inyectar_mensajes() ?>

    <title>Lista de trabajos</title>
</head>

<body>
    <?php require('libs/navbar.php') ?>
    <h1 class="titulo">Lista de trabajos</h1>
    <section id="main">
        <?php if ($_SESSION['usuario']->esta_permitido(PERFIL_REGULAR, SUBSISTEMA_SERVICIO)) { ?>
            <a id="agg" href='/tecnico/trabajos/trabajo.php?id=nuevo'> Registrar nuevo trabajo</a>
        <?php } ?>
        <?= gen_pagination($pagina, $total) ?>
        <div class="element-container">
            <?php
            if ($info_cargada) {
                while ($row = $info->fetch_object()) {
            ?>
                    <div class="element">
                        <p class="element-content">
                            <span class="big"><b></b> <?= htmlspecialchars($row->identificador) ?></span>
                            <hr />
                            <b>Descripción del equipo:</b> <?= nl2br(htmlspecialchars($row->descripcion_equipo)) ?>
                            <hr />
                            <b>Problema:</b> <?= nl2br(htmlspecialchars($row->problema)) ?>
                            <hr />
                            <b>Monto:</b> 
                                <?= htmlspecialchars($row->monto_total) ?>
                                (<?= htmlspecialchars($row->monto_cancelado)?> cancelado)
                            <hr />
                            <b>Estado actual:</b> <?= htmlspecialchars($row->nombre_estado_t) ?>
                            <hr />
                            <hr />
                            <b>Cliente:</b> <?= htmlspecialchars($row->nombre_cliente) ?>
                            <hr />
                            <b>Cédula:</b> <?= htmlspecialchars($row->cedula_cliente) ?>
                            <hr />
                            <b>Teléfono del cliente:</b> <?= htmlspecialchars($row->telefono_cliente) ?>
                            <hr />
                        </p>
                        <?php if ($_SESSION['usuario']->esta_permitido(PERFIL_REGULAR, SUBSISTEMA_TODOS)) { ?>
                        <div class="element-actions">
                            <a href="/tecnico/trabajos/trabajo.php?id=<?= $row->id ?>">Modificar</a>
                            <a class='needs-confirm' href="/internal/tecnico/editar-trabajos.php?modo=eliminar&id=<?= $row->id ?>">Eliminar</a>
                        </div>
                        <?php } ?>
                    </div>
            <?php
                }
            }
            ?>
        </div>
        <?= gen_pagination($pagina, $total) ?>
    </section>
    <div id='popup-container'></div>
</body>

</html>