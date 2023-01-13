<?php
include $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'utils.php';
validar_acceso(PERFIL_SOLOLECTURA, SUBSISTEMA_CYBER);

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
        $stmt = $con->prepare("SELECT
            id, identificador, desc_hardware, desc_software, ubicacion,
            estado, razon_estado, nombre_ubicacion, nombre_estado
        FROM Vista_equipo
        ORDER BY lower(identificador)
        LIMIT ?, ?");
        $stmt->bind_param("ii", $item_offset, $ITEMS_POR_PAGINA);
        $stmt->execute();
        $info = $stmt->get_result();

        $stmt = $con->prepare("SELECT count(id) as total
        FROM Vista_equipo
        ORDER BY identificador");
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

    <title>Inventario de equipos</title>
</head>

<body>
    <?php require('libs/navbar.php') ?>
    <h1 class="titulo">Inventario de equipos</h1>
    <section id="main">
        <?php if ($_SESSION['usuario']->esta_permitido(PERFIL_REGULAR, SUBSISTEMA_CYBER)) { ?>
            <a id="agg" href='/cyber/equipos/equipo.php?id=nuevo'> Registrar equipo</a>
        <?php } ?>
        <?= gen_pagination($pagina, $total) ?>
        <div class="element-container">
            <?php
            if ($info_cargada) {
                while ($row = $info->fetch_object()) {
            ?>
                    <div class="element">
                        <p class="element-content">
                            <span class="big"><b>Identificador:</b> <?= htmlspecialchars($row->identificador) ?></span>
                            <hr />
                            <b>Hardware:</b> <?= nl2br(htmlspecialchars($row->desc_hardware)) ?>
                            <hr />
                            <b>Software:</b> <?= nl2br(htmlspecialchars($row->desc_software)) ?>
                            <hr />
                            <b>Ubicación:</b> <?= htmlspecialchars($row->nombre_ubicacion) ?>
                            <hr />
                            <b>Estado:</b> <?= htmlspecialchars($row->nombre_estado) ?><br>
                            <b>Razón:</b> <?= nl2br(htmlspecialchars($row->razon_estado)) ?>
                            <hr />
                        </p>
                        <?php if ($_SESSION['usuario']->esta_permitido(PERFIL_REGULAR, SUBSISTEMA_TODOS)) { ?>
                        <div class="element-actions">
                            <a href="/cyber/equipos/equipo.php?id=<?= $row->id ?>">Modificar</a>
                            <a class='needs-confirm' href="/internal/cyber/editar-equipos.php?modo=eliminar&id=<?= $row->id ?>">Eliminar</a>
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