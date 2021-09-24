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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Notiluz Administrador | Iniciar Sesion</title>

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


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
