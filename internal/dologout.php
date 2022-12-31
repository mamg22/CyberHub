<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/utils.php';

safe_session_start();
session_unset();
header("Location: /login.php");
?>