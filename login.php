<?php
$mensajeError = "";
if (isset($_GET['e'])) {
  if ($_GET['e'] == 'err_admin') {
    $mensajeError = '
    <div class="alert alert-danger" role="alert">
        Usuario no tiene servicio permisos de administrador!
    </div>
    ';
  }else{
    $mensajeError = '
    <div class="alert alert-danger" role="alert">
        Usuario y/o contraseña incorrecta.
    </div>
    ';
  }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Notiluz Administrador | Iniciar Sesion</title>
    <?php include_once('./M/head.php')?>

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <link href="signin.css" rel="stylesheet">

    
    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
  </head>
  <body class="text-center">
    
<main class="form-signin">
  <form action="C/login.php" method="POST">
    <img class="mb-4" src="./V/img/logo.png" alt="" width="110" height="100">
    <h1 class="h3 mb-3 fw-normal">Iniciar Sesion</h1>

    <div class="form-floating">
      <input type="text" name="user" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Usuario</label>
    </div>
    <div class="form-floating">
      <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Contraseña</label>
    </div>

    <?=$mensajeError?>

    <button class="w-100 btn btn-lg btn-primary" type="submit">Ingresar</button>
    <p class="mt-5 mb-3 text-muted">Maraveca Telecomunicaciones &copy; <?=date('Y')?></p>
  </form>
</main>


    
  </body>
</html>
