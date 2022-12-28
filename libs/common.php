<?php

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

function safe_session_start(): void {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

function perfil_permitido(int $perfil, int $minimo): bool {
    // Menor nivel = Mayor privilegio
    return $perfil <= $minimo;
}

function subsistema_permitido(int $subsistema, int $esperado): bool {
    return $subsistema === $esperado ||
           $subsistema === SUBSISTEMA_TODOS;
}

class Mensaje implements JsonSerializable {
    private string $contenido;
    private string $tipo;

    public const ERROR = 'error';
    public const WARN = 'warn';
    public const OK = 'ok';
    public const INFO = 'info';

    public function contenido() {
        return $this->contenido;
    }

    public function tipo() {
        return $this->tipo;
    }

    public function __construct(string $contenido, string $tipo) {
        $this->contenido = $contenido;
        $this->tipo = $tipo;
    }

    public function jsonSerialize(): mixed {
        return array(
            "contenido" => $this->contenido,
            "tipo" => $this->tipo,
        );
    }
}

function assert_mensajes(): void {
    if (!isset($_SESSION['mensajes']) || !is_array($_SESSION['mensajes'])) {
        $_SESSION['mensajes'] = array();
    }
}

function push_mensaje(Mensaje $mensaje): void {
    assert_mensajes();
    array_push($_SESSION['mensajes'], $mensaje);
}

function pop_mensaje(): Mensaje {
    assert_mensajes();
    return array_pop($_SESSION['mensajes']);
}

function vaciar_mensajes(): void {
    $_SESSION['mensajes'] = array();
}

function inyectar_mensajes(): string {
    assert_mensajes();
    $mensajes = json_encode($_SESSION['mensajes']);
    vaciar_mensajes();
    return <<<HTML
    <script type='text/javascript'>
        var popups = $mensajes;
        setup_popups(popups);
    </script>
    HTML;
}


?>