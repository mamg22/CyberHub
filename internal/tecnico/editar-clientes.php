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
    header("Location: /tecnico/clientes/cliente.php");
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
    header("Location: /tecnico/clientes/cliente.php");
    exit();
}

if ($modo == 'insertar' || $modo == 'insertar-popup' || $modo == 'actualizar') {
    // Verificar que la cedula no esté registrada
    $stmt = $con->prepare("SELECT id
                               FROM Cliente
                               WHERE lower(cedula)=lower(?) AND id!=?");
    $qid = $_REQUEST['id'] == 'nuevo' ? -1 : $_REQUEST['id'];
    $stmt->bind_param("si", $_REQUEST['cedula'], $qid);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows() > 0) {
        push_mensaje(new Mensaje(
            "Ya existe un cliente registrado con esta cédula",
            Mensaje::WARN
        ));
        if ($modo == 'insertar-popup') {
            $modo_ventana = "popup";
        }
        header("Location: /tecnico/clientes/cliente.php?" .
            http_build_query([
                "modo" => $modo,
                "id" => $_REQUEST['id'],
                "modo_ventana" => $modo_ventana ?? null,
            ]));
        exit();
    }
}

if ($modo == 'insertar' || $modo == 'insertar-popup') {
    try {
        $stmt = $con->prepare("INSERT INTO
        Cliente(nombre, telefono_contacto, cedula) VALUES
        (?, ?, ?)");
        $stmt->bind_param("sss", 
            $_REQUEST['nombre'],
            $_REQUEST['telefono_contacto'],
            $_REQUEST['cedula']);
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
        error_log("HERE" . $modo);
    if ($modo == 'insertar-popup') {
        error_log("HERE" . __LINE__);
        header("Location: /internal/close.php");
        exit();
    }
}
else if ($modo == 'actualizar') {
    try {
        $stmt = $con->prepare("UPDATE Cliente SET
            nombre=?,
            telefono_contacto=?,
            cedula=?
            WHERE id=?");
        $stmt->bind_param("sssi", 
            $_REQUEST['nombre'],
            $_REQUEST['telefono_contacto'],
            $_REQUEST['cedula'],
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
        // No permitir eliminar si el cliente tiene trabajos asignados
        $stmt = $con->prepare("SELECT id
                                FROM Trabajo_reparacion
                                WHERE cliente=?");
        $qid = $_REQUEST['id'] == 'nuevo' ? -1 : $_REQUEST['id'];
        $stmt->bind_param("i", $qid);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows() > 0) {
            push_mensaje(new Mensaje(
                "Este cliente tiene trabajos de reparación asignados a su nombre, por lo que no " .
                "puede ser eliminado. Elimine los trabajos de este cliente antes de proceder o " .
                "utilice la opción de \"Eliminar totalmente\" en la pantalla de modificación del " .
                "cliente.",
                Mensaje::WARN
            ));
            header("Location: /tecnico/clientes/?" .
                http_build_query([
                    "modo" => $modo,
                    "id" => $_REQUEST['id']
                ]));
            exit();
        }
        $stmt = $con->prepare("DELETE FROM Cliente WHERE id=?");
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
else if ($modo == 'eliminar-totalmente') {
    try {
        $stmt = $con->prepare("DELETE FROM Trabajo_reparacion WHERE cliente=?");
        $stmt->bind_param("i", $_REQUEST['id']);
        $stmt->execute();

        $stmt = $con->prepare("DELETE FROM Cliente WHERE id=?");
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

header("Location: /tecnico/clientes/");
exit();