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

function obtener_etiquetas(){
    $mysqli = on_bd();
    $sql = "SELECT * FROM etiquetas WHERE status ORDER BY etiqueta ASC";
    $result = $mysqli->query($sql);
    if($mysqli->affected_rows > 0 ){
      $array = array();
      while($row = $result->fetch_array(MYSQLI_ASSOC)){
        array_push($array,$row);
      }
      $return = $array;
    }else {
      $return = [];
    }
    off_bd($mysqli);
    return $return;
}

function obtener_todas_noticias(){
    $mysqli = on_bd();
    $sql = "SELECT * FROM noticia WHERE status";
    $result = $mysqli->query($sql);
    if($mysqli->affected_rows > 0 ){
      $array = array();
      while($row = $result->fetch_array(MYSQLI_ASSOC)){
        array_push($array,$row);
      }
      $return = $array;
    }else {
      $return = [];
    }
    off_bd($mysqli);
    return $return;
}

function generar_validar_url_noticia($string_url_modificado){
    $mysqli = on_bd();
    $sql = "SELECT idnoticia FROM noticia WHERE noticia_url = '$string_url_modificado'";
    $result = $mysqli->query($sql);
    if($mysqli->affected_rows > 0 ){
      $return = $string_url_modificado.'-'.rand();
    }else {
      $return = $string_url_modificado;
    }
    off_bd($mysqli);
    return strtolower($return); //minusculas  
  }


//---------------------------------------LIMPIAR INPUT DE INYECCIONES SQL-----------------------------------------------------------
function cleanInput($input) {

    $search = array(
      '@<script[^>]*?>.*?</script>@si',   // Elimina javascript
      '@<[\/\!]*?[^<>]*?>@si',            // Elimina las etiquetas HTML
      '@<style[^>]*?>.*?</style>@siU',    // Elimina las etiquetas de estilo
      '@<![\s\S]*?--[ \t\n\r]*>@'         // Elimina los comentarios multi-línea
    );
  
      $output = preg_replace($search, '', $input);
      return $output;
    }
  
  function limpiar($input) {
      if (is_array($input)) {
          foreach($input as $var=>$val) {
              $output[$var] = limpiar($val);
          }
      }
      else {
        //   if (get_magic_quotes_gpc()) {
        //       $input = stripslashes($input);
        //   }
          $input  = cleanInput($input);
          //$output = mysql_real_escape_string($input);
          $output = $input;
      }
      return $input;
  }
  function imprimir_mes_espanol($mes){
    if ($mes == 1) {
      $return = 'Enero';
    }elseif ($mes == 2) {
      $return = 'Febrero';
    }elseif ($mes == 3) {
      $return = 'Marzo';
    }elseif ($mes == 4) {
      $return = 'Abril';
    }elseif ($mes == 5) {
      $return = 'Mayo';
    }elseif ($mes == 6) {
      $return = 'Junio';
    }elseif ($mes == 7) {
      $return = 'Julio';
    }elseif ($mes == 8) {
      $return = 'Agosto';
    }elseif ($mes == 9) {
      $return = 'Septiembre';
    }elseif ($mes == 10) {
      $return = 'Octubre';
    }elseif ($mes == 11) {
      $return = 'Noviembre';
    }elseif ($mes == 12) {
      $return = 'Diciembre';
    }
    return $return;
  }

  /* Función que elimina los acantos y letras ñ*/
function quitar_acentos($cadena){
  $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ';
  $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby';
  $cadena = utf8_decode($cadena);
  $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
  return utf8_encode($cadena);
}
