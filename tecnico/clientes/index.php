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
        $stmt = $con->prepare("SELECT
            id, nombre, telefono_contacto, cedula
        FROM Cliente
        ORDER BY lower(nombre)
        LIMIT ?, ?");
        $stmt->bind_param("ii", $item_offset, $ITEMS_POR_PAGINA);
        $stmt->execute();
        $info = $stmt->get_result();

        $stmt = $con->prepare("SELECT count(id) as total
        FROM Cliente
        ORDER BY lower(nombre)");
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

    <title>Lista de clientes</title>
</head>

<body>
    <?php require('libs/navbar.php') ?>
    <h1 class="titulo">Lista de clientes</h1>
    <section id="main">
        <?php if ($_SESSION['usuario']->esta_permitido(PERFIL_REGULAR, SUBSISTEMA_SERVICIO)) { ?>
            <a id="agg" href='/tecnico/clientes/cliente.php?id=nuevo'> Registrar cliente</a>
        <?php } ?>
        <?= gen_pagination($pagina, $total) ?>
        <div class="element-container">
            <?php
            if ($info_cargada) {
                while ($row = $info->fetch_object()) {
            ?>
                    <div class="element">
                        <p class="element-content">
                            <span class="big"><b> <?= htmlspecialchars($row->nombre) ?></b></span>
                            <hr />
                            <b>Cédula:</b> <?= htmlspecialchars($row->cedula) ?>
                            <hr />
                            <b>Teléfono de contacto:</b> <?= htmlspecialchars($row->telefono_contacto) ?>
                            <hr />
                        </p>
                        <?php if ($_SESSION['usuario']->esta_permitido(PERFIL_REGULAR, SUBSISTEMA_TODOS)) { ?>
                        <div class="element-actions">
                            <a href="/tecnico/clientes/cliente.php?id=<?= $row->id ?>">Modificar</a>
                            <a class='needs-confirm' href="/internal/tecnico/editar-clientes.php?modo=eliminar&id=<?= $row->id ?>">Eliminar</a>
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