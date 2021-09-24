<?php
function on_bd(){
    $mysqli = new mysqli("localhost", "root", "", "notiluzinternacional");
    // $mysqli = new mysqli("159.203.124.63", "asambleas", "asambleas", "notiluzinternacional");
    $mysqli->query("SET NAMES 'utf8'");
    if (mysqli_connect_errno()) {
        die("Error al conectar: ".mysqli_connect_error());
    }
    return $mysqli;
}

function off_bd(Mysqli $mysqli){
    $mysqli->close();
}

?>