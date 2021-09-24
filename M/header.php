<nav class="navbar navbar-expand-lg navbar-dark bg-primary" style="background: url('./V/img/background-cabeza5.jpg');background-size: cover;background-position: center;">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= $ruta_inicio ?>">Administración</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?=$inicio_act?>" aria-current="page" href="<?= $ruta_inicio ?>">Inicio</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?=$puertas_act?>" href="#" id="navbarPuertas" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Hrno. Puertas
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarPuertas">
                        <li><a class="dropdown-item" href="<?= $ruta_inicio ?>?p=hrno-puertas-tratados">Tratados</a></li>
                        <li><a class="dropdown-item" href="#">Preguntas y Respuestas</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarNotiluz" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Notiluz
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarNotiluz">
                        <li><a class="dropdown-item" href="#">Noticias</a></li>
                        <li><a class="dropdown-item" href="#">Etiquetas</a></li>
                    </ul>
                </li>
            </ul>
            <div class="d-flex">
                <a class="btn btn-outline-light" href="<?= $ruta_inicio ?>C/salir.php">Salir</a>
            </div>
        </div>
    </div>
</nav>