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
    header("Location: /cyber/equipos/equipo.php");
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
    header("Location: /cyber/equipos/equipo.php");
    exit();
}

if ($modo == 'insertar' || $modo == 'actualizar') {
    $stmt = $con->prepare("SELECT id
                               FROM Equipo
                               WHERE identificador=? AND id!=?");
    $qid = $_REQUEST['id'] == 'nuevo' ? -1 : $_REQUEST['id'];
    $stmt->bind_param("si", $_REQUEST['identificador'], $qid);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows() > 0) {
        push_mensaje(new Mensaje(
            "Ya existe un equipo registrado con este identificador, por favor, utilice otro identificador",
            Mensaje::WARN
        ));
        header("Location: /cyber/equipos/equipo.php?" .
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
        Equipo(identificador, desc_hardware, desc_software, ubicacion, estado, razon_estado) VALUES
        (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiis", 
            $_REQUEST['identificador'],
            $_REQUEST['desc_hardware'],
            $_REQUEST['desc_software'],
            $_REQUEST['ubicacion'],
            $_REQUEST['estado'],
            $_REQUEST['razon_estado']);
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
        $stmt = $con->prepare("UPDATE Equipo SET
            identificador=?,
            desc_hardware=?,
            desc_software=?,
            ubicacion=?,
            estado=?,
            razon_estado=?
            WHERE id=?");
        $stmt->bind_param("sssiisi", 
            $_REQUEST['identificador'],
            $_REQUEST['desc_hardware'],
            $_REQUEST['desc_software'],
            $_REQUEST['ubicacion'],
            $_REQUEST['estado'],
            $_REQUEST['razon_estado'],
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
        $stmt = $con->prepare("DELETE FROM Equipo WHERE id=?");
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

header("Location: /cyber/equipos/");
exit();