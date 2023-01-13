<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/utils.php';


session_unset();
header("Location: /login.php");
?>