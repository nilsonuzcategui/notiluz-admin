<?php
session_start();
unset($_SESSION["notiluz-admin"]);
header('Location: ../login.php');
?>