<?php

require_once('libs/mensajes.php');
require_once('libs/usuario.php');

/**
 * Funcion de utilidad que cambia el manejador de errores de PHP
 * para que marque los errores en el HTML generado.
 * 
 * Obsoleto: Cambiado por las opciones de manejo de errores en `php.ini`
 */
function setup_popup_err_handler(): void {
    function my_handler(Throwable $throwable) {
        echo "<p class='php-err'>ERROR: " . nl2br($throwable);
        die('CRAP!');
    }
    set_exception_handler('my_handler');
}

function mapeo_inverso(array $array): array {
    $flip = array_flip($array);
    return array_merge($array, $flip);
}

function conectar_bd(): mysqli {
    $host = 'localhost';
    $usuario = 'root';
    $contrasena = '';
    $bd = 'bdcyber';

    // Activar los reportes de errores, recomedado por PHP
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    return new mysqli($host, $usuario, $contrasena, $bd);
}

define('SUBSISTEMA_TODOS', 1);
define('SUBSISTEMA_CYBER', 2);
define('SUBSISTEMA_SERVICIO', 3);

define('PERFIL_SUPERADMIN', 10);
define('PERFIL_ADMINISTRADOR', 20);
define('PERFIL_REGULAR', 30);
define('PERFIL_SOLOLECTURA', 40);
define('PERFIL_TODOS', 999);

function safe_session_start(): void {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

function validar_acceso(int $perfil_minimo, int $subsistema_esperado): void {
    $u = $_SESSION['usuario'] ?? null;
    if (!$u) {
        push_mensaje(new Mensaje(
            "No ha iniciado sesión. Inicie sesión con su nombre de usuario y contraseña para continuar",
            Mensaje::ERROR
        ));
        header("Location: /");
        exit();
    }
    else if (!$u->esta_permitido($perfil_minimo, $subsistema_esperado)) {
        push_mensaje(new Mensaje(
            Mensajes_comun::ERR_NO_AUTORIZADO,
            Mensaje::ERROR
        ));
        header("Location: /");
        exit();
    }
}
