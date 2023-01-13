<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/utils.php';

if (isset($_REQUEST['modo'])) {
    $modo = $_REQUEST['modo'];
}
else {
    push_mensaje(new Mensaje(
        "Error interno: No se ha indicado el modo de operación. Intentelo de nuevo y si el error persiste, " .
        "contacte al administrador",
        Mensaje::ERROR
    ));
    header("Location: /tecnico/trabajos/trabajo.php");
    exit();
}


try {
    $con = conectar_bd();
} catch (mysqli_sql_exception $e) {
    error_log($e);
    push_mensaje(new Mensaje(
        Mensajes_comun::ERR_CONECTANDO_BD,
        Mensaje::ERROR
    ));
    header("Location: /tecnico/trabajos/trabajo.php");
    exit();
}

if ($modo == 'insertar' || $modo == 'actualizar') {
    $stmt = $con->prepare("SELECT identificador
                               FROM Trabajo_reparacion
                               WHERE lower(identificador)=lower(?) AND id!=?");
    $qid = $_REQUEST['id'] == 'nuevo' ? -1 : $_REQUEST['id'];
    $stmt->bind_param("si", $_REQUEST['identificador'], $qid);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows() > 0) {
        push_mensaje(new Mensaje(
            "Ya existe un repuesto registrado con este identificador, por favor, " .
            "elija otro identificador",
            Mensaje::WARN
        ));
        header("Location: /tecnico/trabajos/trabajo.php?" .
            http_build_query([
                "modo" => $modo,
                "id" => $_REQUEST['id']
            ]));
        exit();
    }
}

if ($modo == 'insertar') {
    try {
        $stmt = $con->prepare("INSERT INTO
        Trabajo_reparacion(descripcion_equipo, problema, identificador, monto_total, monto_cancelado, estado_t, cliente) VALUES
        (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssddii", 
            $_REQUEST['descripcion_equipo'],
            $_REQUEST['problema'],
            $_REQUEST['identificador'],
            $_REQUEST['monto_total'],
            $_REQUEST['monto_cancelado'],
            $_REQUEST['estado_t'],
            $_REQUEST['cliente']);
        $stmt->execute();

        push_mensaje(new Mensaje(
            Mensajes_comun::OK_INSERT,
            Mensaje::OK
        ));
    } catch (mysqli_sql_exception $e) {
        error_log($e);
        push_mensaje(new Mensaje(
            Mensajes_comun::ERR_INSERT,
            Mensaje::ERROR
        ));
    }
}
else if ($modo == 'actualizar') {
    try {
        $stmt = $con->prepare("UPDATE Trabajo_reparacion SET
            descripcion_equipo=?,
            problema=?,
            identificador=?,
            monto_total=?,
            monto_cancelado=?,
            estado_t=?,
            cliente=?
            WHERE id=?");
        $stmt->bind_param("sssddiii", 
            $_REQUEST['descripcion_equipo'],
            $_REQUEST['problema'],
            $_REQUEST['identificador'],
            $_REQUEST['monto_total'],
            $_REQUEST['monto_cancelado'],
            $_REQUEST['estado_t'],
            $_REQUEST['cliente'],
            $_REQUEST['id']);
        $stmt->execute();

        push_mensaje(new Mensaje(
            Mensajes_comun::OK_UPDATE,
            Mensaje::OK
        ));
    } catch (mysqli_sql_exception $e) {
        error_log($e);
        push_mensaje(new Mensaje(
            Mensajes_comun::ERR_UPDATE,
            Mensaje::ERROR
        ));
    }
}
else if ($modo == 'eliminar') {
    try {
        $stmt = $con->prepare("DELETE FROM Trabajo_reparacion WHERE id=?");
        $stmt->bind_param("i", $_REQUEST['id']);
        $stmt->execute();

        push_mensaje(new Mensaje(
            Mensajes_comun::OK_DELETE,
            Mensaje::OK
        ));
    } catch (mysqli_sql_exception $e) {
        error_log($e);
        push_mensaje(new Mensaje(
            Mensajes_comun::ERR_DELETE,
            Mensaje::ERROR
        ));
    }
}
else {
    push_mensaje(new Mensaje(
        "Error interno: Modo de operación invalido. Intentelo de nuevo y si el error persiste, " .
        "contacte al administrador",
        Mensaje::ERROR
    ));
}

header("Location: /tecnico/trabajos/");
exit();