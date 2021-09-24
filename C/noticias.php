<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

session_start();
$array = array(
    "response" => "error",
    "html" => "",
);
include_once('../M/funciones.php');
$mysqli = on_bd();

$sesion = (isset($_SESSION['notiluz'])) ? $_SESSION['notiluz'] : '';
$iduser = (isset($_SESSION['notiluz'])) ? $sesion['iduser'] : '';

$opt = (isset($_POST['opt'])) ? limpiar($_POST['opt']) : '';

$idnoticia = (isset($_POST['idnoticia'])) ? limpiar($_POST['idnoticia']) : '';
$fecha = (isset($_POST['fecha'])) ? limpiar($_POST['fecha']) : '';
$titulo = (isset($_POST['titulo'])) ? limpiar($_POST['titulo']) : '';
$subtitulo = (isset($_POST['subtitulo'])) ? limpiar($_POST['subtitulo']) : '';
$contenido = (isset($_POST['contenido'])) ? limpiar($_POST['contenido']) : '';
$etiquetas = (isset($_POST['etiquetas'])) ? limpiar($_POST['etiquetas']) : '';
$pais = (isset($_POST['pais'])) ? limpiar($_POST['pais']) : '';
$importante = (isset($_POST['importante'])) ? limpiar($_POST['importante']) : '';
$importante_edit = (isset($_POST['importante_edit'])) ? limpiar($_POST['importante_edit']) : '';

$idetiqueta = (isset($_POST['idetiqueta'])) ? limpiar($_POST['idetiqueta']) : '';
$etiqueta = (isset($_POST['etiqueta'])) ? limpiar($_POST['etiqueta']) : '';

$iduser = (isset($_POST['iduser'])) ? limpiar($_POST['iduser']) : '';
$idnoticia = (isset($_POST['idnoticia'])) ? limpiar($_POST['idnoticia']) : '';
$comentario = (isset($_POST['comentario'])) ? limpiar($_POST['comentario']) : '';
$idcomentario = (isset($_POST['idcomentario'])) ? limpiar($_POST['idcomentario']) : '';

$string = (isset($_POST['string'])) ? limpiar($_POST['string']) : '';
$inicio = (isset($_POST['inicio'])) ? limpiar($_POST['inicio']) : '';
$limite = (isset($_POST['limite'])) ? limpiar($_POST['limite']) : '';

$correo = (isset($_POST['correo'])) ? limpiar($_POST['correo']) : '';

$posicion = (isset($_POST['posicion'])) ? limpiar($_POST['posicion']) : '';




if ($opt == 'add-noticia') {
    $target_path = 'imagenes';
    if (!file_exists($target_path)) {
        mkdir($target_path, 0777, true);
    }
    $img_banner = '';
    $img_cuadrado = '';

    if ($idnoticia == '') { //agregar una noticia
        
        
        if (isset($_FILES['input_logo_1'])) {
            $_FILES['input_logo_1']['name'] = rand().$_FILES['input_logo_1']['name'];
            $img1path = $target_path .'/'.  $_FILES['input_logo_1']['name'];
            $img1path = str_replace("ñ", "n", $img1path);
            if(move_uploaded_file($_FILES['input_logo_1']['tmp_name'], $img1path)){
                $img_banner = str_replace("ñ", "n", $_FILES['input_logo_1']['name']);
            }
        }

        
        if (isset($_FILES['input_logo_2'])) {
            $_FILES['input_logo_2']['name'] = rand().$_FILES['input_logo_2']['name'];
            $img2path = $target_path .'/'.  $_FILES['input_logo_2']['name'];
            $img2path = str_replace("ñ", "n", $img2path);
            if(move_uploaded_file($_FILES['input_logo_2']['tmp_name'], $img2path)){
                $img_cuadrado = str_replace("ñ", "n", $_FILES['input_logo_2']['name']);
            }
        }

        $num_importante = ($importante == 'on') ? 1 : 0;
        $iduser = $sesion['iduser'];

        //generar url de la noticia!
        $noticia_url = quitar_acentos($titulo); // quita acentos y ñ
        $noticia_url = str_replace(" ", "-", $noticia_url); //cambia los espacios por -
        //validar si se repite o no se repite
        $noticia_url = generar_validar_url_noticia($noticia_url);

        // $sql = "INSERT INTO `noticia` (`iduser`, `fecha`, `titulo`, `subtitulo`, `contenido`, `baner`, `imagen`, `pais`, `importante`, `noticia_url`) 
        // VALUES ($iduser, '$fecha', '$titulo', '$subtitulo', '$contenido', '$img_banner', '$img_cuadrado', '$pais', '$num_importante','$noticia_url');";
        // $result = $mysqli->query($sql);
        // if($mysqli->affected_rows > 0 ){
        //     $idnoticia = $mysqli->insert_id;
        //     //agregar etiquetas
        //     foreach ($etiquetas as $idetiqueta) {
        //         $sql2 = "INSERT INTO `noticia_etiqueta` (`idnoticia`, `idetiqueta`) VALUES ($idnoticia, $idetiqueta);";
        //         $result = $mysqli->query($sql2);
        //     }
        //     $array['response'] = 'exito';
        // }else {
        //     $array['response'] = 'error_insert';
        //     $array['sql'] = $sql;
        // }
        $array['response'] = 'exito';
    }else { //editar una noticia
        $noticia = obtener_noticia_detallada_id($idnoticia);
        if ($noticia != 0) {
            // IMAGENES
            $baner_agregado = false;
            $sql_baner = '';
            $imagen_agregado = false;
            $sql_imagen = '';
            if (isset($_FILES['input_logo_1'])) {
                if ($_FILES['input_logo_1']['name'] != $noticia['baner']) {
                    $_FILES['input_logo_1']['name'] = rand().$_FILES['input_logo_1']['name'];
                    $img1path = $target_path .'/'.  $_FILES['input_logo_1']['name'];
                    $img1path = str_replace("ñ", "n", $img1path);
                    if(move_uploaded_file($_FILES['input_logo_1']['tmp_name'], $img1path)){
                        $img_banner = str_replace("ñ", "n", $_FILES['input_logo_1']['name']);
                        $baner_agregado = true;
                        $sql_baner = "`baner`='$img_banner',";
                    }
                }
            }
            if (isset($_FILES['input_logo_2'])) {
                if ($_FILES['input_logo_2']['name'] != $noticia['imagen']) {
                    $_FILES['input_logo_2']['name'] = rand().$_FILES['input_logo_2']['name'];
                    $img2path = $target_path .'/'.  $_FILES['input_logo_2']['name'];
                    $img2path = str_replace("ñ", "n", $img2path);
                    if(move_uploaded_file($_FILES['input_logo_2']['tmp_name'], $img2path)){
                        $img_banner = str_replace("ñ", "n", $_FILES['input_logo_2']['name']);
                        $imagen_agregado = true;
                        $sql_baner = "`imagen`='$img_banner',";
                    }
                }
            }

            //generar url de la noticia!
            $noticia_url = quitar_acentos($titulo); // quita acentos y ñ
            $noticia_url = str_replace(" ", "-", $noticia_url); //cambia los espacios por -
            //validar si se repite o no se repite
            if ($noticia['noticia_url'] != strtolower($noticia_url)) {
                $noticia_url = generar_validar_url_noticia($noticia_url);
            }
            

            //modificar contenido de la noticia
            $sql = "UPDATE `noticia` SET `fecha`='$fecha', `titulo`='$titulo', `subtitulo`='$subtitulo', `contenido`='$contenido', 
            $sql_baner $sql_imagen `pais`='$pais', `importante`=$importante_edit, `noticia_url` = '$noticia_url'
            WHERE `idnoticia`=$idnoticia;";
            $result = $mysqli->query($sql);
            if($mysqli->affected_rows > 0 ){
                //eliminar imagen anterior
                if ($baner_agregado) {
                    if ($noticia['baner'] != '') {
                        unlink($target_path .'/'.  $noticia['baner']);
                    }
                }
                if ($imagen_agregado) {
                    if ($noticia['imagen'] != '') {
                        unlink($target_path .'/'.  $noticia['imagen']);
                    }
                }
            }

            $array['sql'] = $sql;

            //modificiar etiquetas
            $sql = "DELETE FROM `noticia_etiqueta` WHERE `idnoticia`=$idnoticia;";
            $result = $mysqli->query($sql);

            foreach ($etiquetas as $idetiqueta) {
                $sql2 = "INSERT INTO `noticia_etiqueta` (`idnoticia`, `idetiqueta`) VALUES ($idnoticia, $idetiqueta);";
                $result = $mysqli->query($sql2);
            }

            $array['response'] = 'exito';
        }else {
            $array['response'] = 'error_obtener_datos_noticia';
        }
    }
}elseif ($opt == 'add-noticia-img') {
    if ($idnoticia == 0 || $idnoticia == '') {
        $array['response'] = 'no_hay_idnoticia';
    }else {
        $target_path = 'imagenes';
        if (!file_exists($target_path)) {
            mkdir($target_path, 0777, true);
        }

        //GESTION DE LA PRIMERA IMAGEN
        $img_1 = '';
        if (isset($_FILES['input_logo_1'])) {
            $_FILES['input_logo_1']['name'] = rand().$_FILES['input_logo_1']['name'];
            $img1path = $target_path .'/'.  $_FILES['input_logo_1']['name'];
            $img1path = str_replace("ñ", "n", $img1path);
            if(move_uploaded_file($_FILES['input_logo_1']['tmp_name'], $img1path)){
                $img_1 = str_replace("ñ", "n", $_FILES['input_logo_1']['name']);
            }

            if ($img_1 != '') { //si se guardo en el FTP
                //eliminar imagen anterior
                $sql_bus = "SELECT * FROM noticia_imagenes WHERE idnoticia = $idnoticia AND posicion = 1";
                $result = $mysqli->query($sql_bus);
                if($mysqli->affected_rows > 0 ){
                    $datos = $result->fetch_array(MYSQLI_ASSOC);
                    $sql_eli = "DELETE FROM `noticia_imagenes` WHERE `idnoticia_imagen`= ".$datos['idnoticia_imagen'];
                    $result = $mysqli->query($sql_eli);
                    unlink($target_path .'/'.  $datos['imagen']);
                }

                //agregar la imagen
                $sql = "INSERT INTO `noticia_imagenes` (`idnoticia`, `posicion`, `imagen`) VALUES ($idnoticia, 1, '$img_1');";
                $result = $mysqli->query($sql);
            }
        }

        //GESTION DE LA SEGUNDA IMAGEN
        $img_2 = '';
        if (isset($_FILES['input_logo_2'])) {
            $_FILES['input_logo_2']['name'] = rand().$_FILES['input_logo_2']['name'];
            $img2path = $target_path .'/'.  $_FILES['input_logo_2']['name'];
            $img2path = str_replace("ñ", "n", $img2path);
            if(move_uploaded_file($_FILES['input_logo_2']['tmp_name'], $img2path)){
                $img_2 = str_replace("ñ", "n", $_FILES['input_logo_2']['name']);
            }
            if ($img_2 != '') { //si se guardo en el FTP
                //eliminar imagen anterior
                $sql_bus = "SELECT * FROM noticia_imagenes WHERE idnoticia = $idnoticia AND posicion = 2";
                $result = $mysqli->query($sql_bus);
                if($mysqli->affected_rows > 0 ){
                    $datos = $result->fetch_array(MYSQLI_ASSOC);
                    $sql_eli = "DELETE FROM `noticia_imagenes` WHERE `idnoticia_imagen`= ".$datos['idnoticia_imagen'];
                    $result = $mysqli->query($sql_eli);
                    unlink($target_path .'/'.  $datos['imagen']);
                }

                //agregar la imagen
                $sql = "INSERT INTO `noticia_imagenes` (`idnoticia`, `posicion`, `imagen`) VALUES ($idnoticia, 2, '$img_2');";
                $result = $mysqli->query($sql);
            }
        }

        //GESTION DE LA TERCERA IMAGEN
        $img_3 = '';
        if (isset($_FILES['input_logo_3'])) {
            $_FILES['input_logo_3']['name'] = rand().$_FILES['input_logo_3']['name'];
            $img3path = $target_path .'/'.  $_FILES['input_logo_3']['name'];
            $img3path = str_replace("ñ", "n", $img3path);
            if(move_uploaded_file($_FILES['input_logo_3']['tmp_name'], $img3path)){
                $img_3 = str_replace("ñ", "n", $_FILES['input_logo_3']['name']);
            }
            if ($img_3 != '') { //si se guardo en el FTP
                //eliminar imagen anterior
                $sql_bus = "SELECT * FROM noticia_imagenes WHERE idnoticia = $idnoticia AND posicion = 3";
                $result = $mysqli->query($sql_bus);
                if($mysqli->affected_rows > 0 ){
                    $datos = $result->fetch_array(MYSQLI_ASSOC);
                    $sql_eli = "DELETE FROM `noticia_imagenes` WHERE `idnoticia_imagen`= ".$datos['idnoticia_imagen'];
                    $result = $mysqli->query($sql_eli);
                    unlink($target_path .'/'.  $datos['imagen']);
                }

                //agregar la imagen
                $sql = "INSERT INTO `noticia_imagenes` (`idnoticia`, `posicion`, `imagen`) VALUES ($idnoticia, 3, '$img_3');";
                $result = $mysqli->query($sql);
            }
        }

        //GESTION DE LA CUARTA IMAGEN
        $img_4 = '';
        if (isset($_FILES['input_logo_4'])) {
            $_FILES['input_logo_4']['name'] = rand().$_FILES['input_logo_4']['name'];
            $img4path = $target_path .'/'.  $_FILES['input_logo_4']['name'];
            $img4path = str_replace("ñ", "n", $img4path);
            if(move_uploaded_file($_FILES['input_logo_4']['tmp_name'], $img4path)){
                $img_4 = str_replace("ñ", "n", $_FILES['input_logo_4']['name']);
            }
            if ($img_4 != '') { //si se guardo en el FTP
                //eliminar imagen anterior
                $sql_bus = "SELECT * FROM noticia_imagenes WHERE idnoticia = $idnoticia AND posicion = 4";
                $result = $mysqli->query($sql_bus);
                if($mysqli->affected_rows > 0 ){
                    $datos = $result->fetch_array(MYSQLI_ASSOC);
                    $sql_eli = "DELETE FROM `noticia_imagenes` WHERE `idnoticia_imagen`= ".$datos['idnoticia_imagen'];
                    $result = $mysqli->query($sql_eli);
                    unlink($target_path .'/'.  $datos['imagen']);
                }

                //agregar la imagen
                $sql = "INSERT INTO `noticia_imagenes` (`idnoticia`, `posicion`, `imagen`) VALUES ($idnoticia, 4, '$img_4');";
                $result = $mysqli->query($sql);
            }
        }


        $array['response'] = 'exito';
    }
}elseif ($opt == 'eliminar_noticia') {
    $sql = "UPDATE `noticia` SET `status`='0' WHERE `idnoticia`=$idnoticia;";
    $result = $mysqli->query($sql);
    if($mysqli->affected_rows > 0 ){
        $array['response'] = 'exito';
    }else {
        $array['response'] = 'error_eliminar';
    }
}elseif ($opt == 'eliminar_noticia_img') {
    $target_path = 'imagenes';
    if (!file_exists($target_path)) {
        mkdir($target_path, 0777, true);
    }
    $sql_bus = "SELECT * FROM noticia_imagenes WHERE idnoticia = $idnoticia AND posicion = $posicion";
    $result = $mysqli->query($sql_bus);
    if($mysqli->affected_rows > 0 ){
        $datos = $result->fetch_array(MYSQLI_ASSOC);
        $sql_eli = "DELETE FROM `noticia_imagenes` WHERE `idnoticia_imagen`= ".$datos['idnoticia_imagen'];
        $result = $mysqli->query($sql_eli);
        unlink($target_path .'/'.  $datos['imagen']);
        $array['response'] = 'exito';
    }else {
        $array['response'] = 'error_eliminar';
    }
}elseif ($opt == 'buscar_noticia') {
    $sql = "SELECT * FROM noticia WHERE idnoticia = $idnoticia";
    $result = $mysqli->query($sql);
    if($mysqli->affected_rows > 0 ){
        $array['arrayAux'] = $result->fetch_array(MYSQLI_ASSOC);
        $array['arrayEtiquetas'] = buscar_etiqueta_noticia_admin($idnoticia);

        $date = date_create($array['arrayAux']['fecha']);
        $array['arrayAux']['fecha'] = str_replace(" ", "T", date_format($date, 'Y-m-d H:i'));

        $array['response'] = 'exito';
    }else {
        $array['response'] = 'error_obtener_datos';
    }
}elseif ($opt == 'add_etiqueta') {
    if ($idetiqueta == '') {
        $sql = "INSERT INTO `etiquetas` (`etiqueta`) VALUES ('$etiqueta');";
        $result = $mysqli->query($sql);
        if($mysqli->affected_rows > 0 ){
            $array['response'] = 'exito';
        }else {
            $array['response'] = 'error_insert';
        }
    }else {
        $sql = "UPDATE `etiquetas` SET `etiqueta`='$etiqueta' WHERE `idetiqueta`=$idetiqueta;";
        $result = $mysqli->query($sql);
        $array['response'] = 'exito';
    }
}elseif ($opt == 'eliminar_etiqueta') {
    $sql = "UPDATE `etiquetas` SET `status`='0' WHERE `idetiqueta`=$idetiqueta;";
    $result = $mysqli->query($sql);
    if($mysqli->affected_rows > 0 ){
        $array['response'] = 'exito';
    }else {
        $array['response'] = 'error_eliminar';
    }
}elseif ($opt == 'add_comentario') {
    $sql = "INSERT INTO `noticia_comentarios` (`iduser`, `idnoticia`, `comentario`,`fecha`, `correo`) 
    VALUES ('$iduser', $idnoticia, '$comentario', NOW(), '$correo' );";
    $result = $mysqli->query($sql);
    if($mysqli->affected_rows > 0 ){
        $array['response'] = 'exito';
    }else {
        $array['response'] = 'error_comentar';
    }
}elseif ($opt == 'eliminar_comentario') {
    $sql = "UPDATE `noticia_comentarios` SET `status`='0' WHERE `idcomentario`=$idcomentario;";
    $result = $mysqli->query($sql);
    if($mysqli->affected_rows > 0 ){
        $array['response'] = 'exito';
    }else {
        $array['response'] = 'error_eliminar';
    }
}elseif ($opt == 'add_comentario_agro') {
    $sql = "INSERT INTO `comentarios_agroecoluz` (`iduser`, `comentario`,`fecha`, `correo`) 
    VALUES ('$iduser', '$comentario', NOW(), '$correo' );";
    $result = $mysqli->query($sql);
    if($mysqli->affected_rows > 0 ){
        $array['response'] = 'exito';
    }else {
        $array['response'] = 'error_comentar';
    }
}elseif ($opt == 'eliminar_comentario_agro') {
    $sql = "UPDATE `comentarios_agroecoluz` SET `status`='0' WHERE `idcomentario`=$idcomentario;";
    $result = $mysqli->query($sql);
    if($mysqli->affected_rows > 0 ){
        $array['response'] = 'exito';
    }else {
        $array['response'] = 'error_eliminar';
    }
}elseif ($opt == 'noticia_busqueda') {
    $sql = "SELECT n.idnoticia, n.iduser, n.fecha, n.titulo, n.subtitulo, n.contenido, n.noticia_url,
    n.baner, n.imagen, n.pais
    FROM noticia n
    LEFT JOIN noticia_etiqueta ne ON n.idnoticia=ne.idnoticia
    LEFT JOIN etiquetas e ON ne.idetiqueta=e.idetiqueta
    WHERE n.status AND (n.titulo LIKE '%$string%' || e.etiqueta LIKE '%$string%')
    GROUP BY n.idnoticia
    ORDER BY n.idnoticia DESC
    LIMIT $inicio,$limite";
    $result = $mysqli->query($sql);
    $array['numFilas'] = $mysqli->affected_rows;
    if($mysqli->affected_rows > 0 ){
        //RUTA PARA IMAGENES
        if($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '192.168.1.16'){
            $ruta_inicio = "/notiluzinternacional/";
        }else{
            $ruta_inicio = "/";
        }
        $html = '';
        while($row = $result->fetch_array(MYSQLI_ASSOC)){
            $titulo_url = str_replace(" ", "+", $row['titulo']);
            $desde_aux = ($row['pais']=='') ? 'NOTILUZ INTERNACIONAL' : $row['pais'];
            $date = date_create($row['fecha']);
            $comentarios = obtener_comentarios_noticia($row['idnoticia']);
            // $num_comentarios = ($comentarios==0) ? 0 : count($comentarios);
            //calcular el tamaño del contenido y cortarlo
            $contenidoAux = '';
            $num_limite = 300;
            $logitud_contenido = strlen($row['contenido']);
            if ($logitud_contenido <= $num_limite) {
                $contenidoAux = $row['contenido'];
            }else {
                // $contenidoAux = substr($row['contenido'], 0, $num_limite).'...';
                // $contenidoAux = $logitud_contenido;
                $text = nl2br(htmlentities($row['contenido'], ENT_QUOTES, 'UTF-8'));
                $contenidoAux = substr($text, 0, $num_limite).'...';
            }
            ob_start();
            ?>


                    <div class="single-blog-area blog-style-2 mb-50 wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="1000ms">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-6">
                                <div class="single-blog-thumbnail">
                                    <div style="
                                    width: 100%;
                                    height: 300px;
                                    background-image: url('<?=$ruta_inicio?>apis/imagenes/<?=$row['imagen']?>');
                                    background-size: cover;
                                    background-position: center;
                                    background-repeat: no-repeat;
                                    "></div>
                                    <div class="post-date">
                                        <a href="<?=$ruta_inicio?>noticia/?n=<?=$row['noticia_url']?>">
                                            <?=date_format($date, 'd')?>
                                            <span>
                                            
                                            <?=imprimir_mes_espanol(date_format($date, 'm'))?>
                                        </span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                               
                                <div class="single-blog-content">
                                    <div class="line"></div>
                                    <a href="<?=$ruta_inicio?>noticia/?n=<?=$row['noticia_url']?>" class="post-tag"><?=$row['subtitulo']?></a>
                                    <h4><a href="<?=$ruta_inicio?>noticia/?n=<?=$row['noticia_url']?>" class="post-headline"><?=$row['titulo']?></a></h4>
                                    <p><?=$contenidoAux?></p>
                                    <div class="post-meta">
                                        <p>Desde <a href="<?=$ruta_inicio?>noticia/?n=<?=$row['noticia_url']?>"><?=$desde_aux?></a></p>
                                        <!-- <p><?=$num_comentarios?> comentarios</p> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



            <?php
            $html .= ob_get_clean();
        }
        $array['html'] = $html;
        $array['response'] = 'exito';
    }else {
        //$array['response'] = 'no_resultados';
        // $array['sql'] = $sql;
    }
}elseif ($opt == 'noticia_inicio') {//------------------------------------------NOTICAS EN EL INICIO
    $sql_filtrado_pais = ($pais == '') ? '' : " AND n.pais = '".$pais."'";
    $sql = "SELECT n.idnoticia, n.iduser, n.fecha, n.titulo, n.subtitulo, n.contenido, n.noticia_url, 
    n.baner, n.imagen, n.pais
    FROM noticia n
    WHERE n.status $sql_filtrado_pais
    GROUP BY n.idnoticia
    ORDER BY n.idnoticia DESC
    LIMIT $inicio, $limite";
    $result = $mysqli->query($sql);
    $array['numFilas'] = $mysqli->affected_rows;
    if($mysqli->affected_rows > 0 ){
        //RUTA PARA IMAGENES
        if($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '192.168.1.16'){
            $ruta_inicio = "/notiluzinternacional/";
        }else{
            $ruta_inicio = "/";
        }
        $html = '';
        while($row = $result->fetch_array(MYSQLI_ASSOC)){
            $titulo_url = str_replace(" ", "+", $row['titulo']);
            $desde_aux = ($row['pais']=='') ? 'NOTILUZ INTERNACIONAL' : $row['pais'];
            $date = date_create($row['fecha']);
            $comentarios = obtener_comentarios_noticia($row['idnoticia']);
            //calcular el tamaño del contenido y cortarlo
            $contenidoAux = '';
            $num_limite = 300;
            $logitud_contenido = strlen($row['contenido']);
            if ($logitud_contenido <= $num_limite) {
                $contenidoAux = $row['contenido'];
            }else {
                // $contenidoAux = substr($row['contenido'], 0, $num_limite).'...';
                // $contenidoAux = $logitud_contenido;
                $text = nl2br(htmlentities($row['contenido'], ENT_QUOTES, 'UTF-8'));
                $contenidoAux = substr($text, 0, $num_limite).'...';
            }
            ob_start();
            ?>


                    <div class="single-blog-area blog-style-2 mb-50 wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="1000ms">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-6">
                                <div class="single-blog-thumbnail">
                                    <div style="
                                    width: 100%;
                                    height: 300px;
                                    background-image: url('<?=$ruta_inicio?>apis/imagenes/<?=$row['imagen']?>');
                                    background-size: cover;
                                    background-position: center;
                                    background-repeat: no-repeat;
                                    "></div>
                                    <div class="post-date">
                                        <a href="<?=$ruta_inicio?>noticia/?n=<?=$row['noticia_url']?>">
                                            <?=date_format($date, 'd')?>
                                            <span>
                                            
                                            <?=imprimir_mes_espanol(date_format($date, 'm'))?>
                                        </span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                               
                                <div class="single-blog-content">
                                    <div class="line"></div>
                                    <a href="<?=$ruta_inicio?>noticia/?n=<?=$row['noticia_url']?>" class="post-tag"><?=$row['subtitulo']?></a>
                                    <h4><a href="<?=$ruta_inicio?>noticia/?n=<?=$row['noticia_url']?>" class="post-headline"><?=$row['titulo']?></a></h4>
                                    <p>
                                        <a href="<?=$ruta_inicio?>noticia/?n=<?=$row['noticia_url']?>" class="post-headline"><?=$contenidoAux?></a>
                                    </p>
                                    <div class="post-meta">
                                        <p>Desde <a href="<?=$ruta_inicio?>noticia/?n=<?=$row['noticia_url']?>"><?=$desde_aux?></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



            <?php
            $html .= ob_get_clean();
        }
        $array['html'] = $html;
        
        $array['response'] = 'exito';
    }else {
        //$array['response'] = 'no_resultados';
        // $array['sql'] = $sql;
    }
    $array['sql'] = $sql;
}





$mysqli->close();
echo json_encode($array);
?>