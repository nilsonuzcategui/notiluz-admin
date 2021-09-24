<?php
include('../M/funciones.php');

if (isset($_POST['user']) && $_POST['user'] != '') {
    if (isset($_POST['password']) && $_POST['password'] != '') {
        //Variables del formulario
        $correo = $_POST['user'];
        $password = $_POST['password'];

        $mysqli = on_bd();
        $sql = "SELECT * FROM user_data WHERE correo = '$correo' AND clave = '$password' LIMIT 1;";
        $result = $mysqli->query($sql);
        if($mysqli->affected_rows > 0 ){
            $datos = $result->fetch_array(MYSQLI_ASSOC);
            //validar si es usuario administrador
            if ($datos['admin'] == 1) {
                session_start();
                $_SESSION["notiluz-admin"] = $datos;
                header('Location: ../');
            }else{
                header('Location: ../login.php?e=err_admin');
            }
        }else{
            header('Location: ../login.php?e=err');
        }
    }else {
        header('Location: ../login.php?e=err');
    }
}else {
    header('Location: ../login.php?e=err');
}
