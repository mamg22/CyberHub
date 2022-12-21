<?php
include $_SERVER['DOCUMENT_ROOT'] . '/utils.php';

safe_session_start();
session_destroy();
header("Location: /login.php");
?>