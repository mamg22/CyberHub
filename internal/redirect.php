<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/utils.php';
session_start();

$redir_target = $_REQUEST['target'];
$sub_actual = $_SESSION['subsistema_actual'];
switch ($redir_target) {
    case 'menu':
        if ($sub_actual === SUBSISTEMA_CYBER) {
            header("Location: /cyber/menu-principal.php");
        }
        else {
            header("Location: /tecnico/menu-principal.php");
        }
        break;
    case 'cambiarpass':
    default:
        header("Location: /");
        break;
}