<?php
session_start();
if (isset($_SESSION["notiluz-admin"])) {
    include_once('./M/funciones.php');
    $html_insert = './V/inicio.php';

    $inicio_act = '';
    $puertas_act = '';
    $notiluz_act = '';
    if (isset($_GET['p'])) {
        $pag_get = $_GET['p'];
        if ($pag_get == 'hrno-puertas-tratados') {
            $puertas_act = 'active';
            $html_insert = './V/puertas_tratado.php';
        }elseif($pag_get == 'notiluz-noticias'){
            $notiluz_act = 'active';
            $html_insert = './V/notiluz-noticia.php';
        }else{
            $inicio_act = 'active';
        }
    }else{
        $inicio_act = 'active';
    }
?>
    <!doctype html>
    <html lang="es">
    <head>
        <title>Notiluz Administrador</title>
        <?php include_once('./M/head.php')?>
        <style>
            .cursor-pointer{
                cursor: pointer;
            }
        </style>
    </head>

    <body>
        <header>
            <?php include_once('./M/header.php')?>
        </header>
        <main class="container">
            <?php include_once($html_insert)?>
        </main>
    </body>

    </html>



<?php
} else {
    header('Location: login.php');
}
?>