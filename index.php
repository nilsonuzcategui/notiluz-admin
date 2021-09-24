<?php
session_start();
if (isset($_SESSION["notiluz-admin"])) {

}else{
    header('Location: login.php');
}
?>