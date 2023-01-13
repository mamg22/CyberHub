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
    header("Location: /comun/usuarios.php");
    exit();
}


try {
    $con = conectar_bd();
} catch (mysqli_sql_exception $e) {
    push_mensaje(new Mensaje(
        Mensajes_comun::ERR_CONECTANDO_BD,
        Mensaje::ERROR
    ));
    header("Location: /comun/usuarios.php");
    exit();
}

if ($modo == 'insertar' || $modo == 'actualizar') {
    $stmt = $con->prepare("SELECT id
                               FROM Usuario
                               WHERE nombre=? AND id!=?");
    $qid = $_REQUEST['id'] == 'nuevo' ? -1 : $_REQUEST['id'];
    $stmt->bind_param("si", $_REQUEST['nombre'], $qid);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows() > 0) {
        push_mensaje(new Mensaje(
            "Ya existe un usuario registrado con este nombre, por favor, utilice otro nombre",
            Mensaje::WARN
        ));
        header("Location: /comun/editar-usuario.php?" .
            http_build_query([
                "modo" => $modo,
                "id" => $_REQUEST['id']
            ]));
        exit();
    }
}

if ($modo == 'insertar') {
    try {
        $hash_clave = password_hash($_REQUEST['clave'], PASSWORD_BCRYPT);
        $hash_pin = password_hash($_REQUEST['pin'], PASSWORD_BCRYPT);

        $stmt = $con->prepare("INSERT INTO
        Usuario(nombre, clave, pin_recuperacion, cedula, subsistema, perfil) VALUES
        (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssii", 
            $_REQUEST['nombre'],
            $hash_clave,
            $hash_pin,
            $_REQUEST['cedula'],
            $_REQUEST['subsistema'],
            $_REQUEST['perfil']);
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
        $stmt = $con->prepare("UPDATE Usuario SET
            nombre=?,
            cedula=?,
            perfil=?
            WHERE id=?");
        $stmt->bind_param("ssii", 
            $_REQUEST['nombre'],
            $_REQUEST['cedula'],
            $_REQUEST['perfil'],
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
    header("Location: /comun/usuarios.php");
    exit();
}
else if ($modo == 'eliminar') {
    try {
        $stmt = $con->prepare("DELETE FROM Usuario WHERE id=?");
        $stmt->bind_param("i", $_REQUEST['id'],);
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

header("Location: /comun/usuarios.php");
exit();