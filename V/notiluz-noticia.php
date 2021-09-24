<?php
$etiquetas = obtener_etiquetas();
$noticias = obtener_todas_noticias();
//rutas para las noticias desde el admin
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    $ruta_noticia = "/notiluz-mdb/noticia/";
} else {
    $ruta_noticia = "/noticia/";
}
?>

<style>
    .insertar_imagen {
        display: table;
        margin: auto;
        border: dotted;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 20%;
    }

    .cursor_p {
        cursor: pointer;
    }

    .vista_file img {
        max-width: 80% !important;
        margin-bottom: 20px !important;
    }
</style>
<div class="row mt-4">
    <div class="col-md-6">
        <h3>Noticias Notiluz</h3>
    </div>

    <div class="col-md-6 text-end">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb" style="justify-content: end;">
                <li class="breadcrumb-item"><a href="<?= $ruta_inicio ?>">Inicio</a></li>
                <li class="breadcrumb-item">Notiluz</li>
                <li class="breadcrumb-item active" aria-current="page">Noticias</li>
            </ol>
        </nav>
    </div>

    <div class="col-md-12">
        <hr>


        <form id="add-noticia" enctype="multipart/form-data" method="post">
            <input type="hidden" name="opt" value="add-noticia">
            <input type="hidden" name="idnoticia" id="idnoticia" value="">



            <div class="form-group row">
                <input type="file" name="input_logo_1" class="form-control input_file" id="input_logo_1" style="display:none;" data-viewlabel="label_logo_1" data-bd="logo_1">
                <label for="input_logo_1" class="col-md-12 text-center cursor_p" id="label_logo_1">
                    <div class="">
                        <div class="row">
                            <span class="col-4 col-form-label">Imagen Banner 1555x655 *</span>

                        </div>
                        <hr>
                        <div class="text-muted vista_file">
                            <div class="insertar_imagen">
                                Insertar una imagen
                                <br>
                                <span class="icono_img">
                                    <i class="fa fa-camera fa-3x"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </label>
            </div>

            <div class="form-group row">
                <input type="file" name="input_logo_2" class="form-control input_file" id="input_logo_2" style="display:none;" data-viewlabel="label_logo_2" data-bd="logo_2">
                <label for="input_logo_2" class="col-md-12 text-center cursor_p" id="label_logo_2">
                    <div class="">
                        <div class="row">
                            <span class="col-4 col-form-label">Imagen Cuadrada *</span>

                        </div>
                        <hr>
                        <div class="text-muted vista_file">
                            <div class="insertar_imagen">
                                Insertar una imagen
                                <br>
                                <span class="icono_img">
                                    <i class="fa fa-camera fa-3x"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </label>
            </div>

            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input type="datetime-local" class="form-control" id="fecha" name="fecha" required>
            </div>
            <div class="form-group">
                <label for="titulo">Titulo</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="form-group">
                <label for="subtitulo">Sub Titulo</label>
                <input type="text" class="form-control" id="subtitulo" name="subtitulo">
            </div>
            <div class="form-group">
                <label for="contenido">Contenido</label>
                <textarea type="text" rows="10" class="form-control" id="contenido" name="contenido" required></textarea>
            </div>

            <div class="form-group">
                <label for="pais">Pais</label>
                <select class="form-control js-example-basic-single" id="pais" name="pais" style="width: 100%">
                    <option value="">Internacional</option>
                    <option>Venezuela</option>
                    <option>Brasil</option>
                    <option>Ecuador</option>
                    <option>Colombia</option>
                    <option>Uruguay</option>
                    <option>Bolivia</option>
                    <option>España</option>
                    <option>Nicaragua</option>
                    <option>Paraguay</option>
                    <option>Mexico</option>
                    <option>Peru</option>
                    <option>Honduras</option>
                    <option>Chile</option>
                    <option>Argentina</option>
                    <option>Curacao</option>
                </select>
            </div>

            <div class="form-group">
                <label for="etiquetas[]">Etiquetas</label>
                <select class="js-example-basic-multiple" name="etiquetas[]" id="etiquetas" multiple="multiple" style="width: 100%" required>
                    <?php
                    foreach ($etiquetas as $row) {
                        echo '
                            <option value="' . $row['idetiqueta'] . '">' . $row['etiqueta'] . '</option>
                            ';
                    }
                    ?>
                </select>
                <small class="form-text text-muted">Las etiquetas facilitarán la busqueda, Primero tiene que agregarlas en la seccion de Etiquetas.</small>
            </div>

            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="importante" name="importante">
                <label class="form-check-label" for="importante">Importante</label>
                <small class="form-text text-muted">Saldrá de primero en el inicio</small>
            </div>

            <div class="form-group mt-3 text-center">
                <div id="loadingForm" style="display:none;">
                    <div class="lds-hourglass"></div>
                </div>



                <button type="submit" class="btn btn-primary" id="botonForm">Guardar</button>

            </div>

        </form>


        <hr>
        <h4>Listado de Noticas</h4>
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table id="dtBasicExample" class="table" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm">Fecha</th>
                            <th class="th-sm">Titulo</th>
                            <th class="th-sm">Sub-Titulo</th>
                            <th class="th-sm">Pais</th>
                            <th class="th-sm">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($noticias as $row) {
                            $paisAux = ($row['pais'] == '') ? 'Internacional' : $row['pais'];
                            echo '
                    <tr>
                        <td>' . $row['fecha'] . '</td>
                        <td>' . $row['titulo'] . '</td>
                        <td>' . $row['subtitulo'] . '</td>
                        <td>' . $paisAux . '</td>
                        <td>
                            <i class="fa fa-pencil-square-o fa-2x text-muted cursor-pointer editar_noticia" data-id="' . $row['idnoticia'] . '" aria-hidden="true" style="font-size: 20px;"></i>
                            <i class="fa fa-eraser fa-2x text-muted cursor-pointer borrar_noticia" data-id="' . $row['idnoticia'] . '" aria-hidden="true" style="font-size: 20px;"></i>
                            <a href="' . $ruta_noticia . 'admin-noticias-img?i=' . $row['idnoticia'] . '">
                                <i class="fa fa-picture-o fa-2x text-muted cursor-pointer" aria-hidden="true" style="font-size: 20px;"></i>
                            </a>
                            <a href="' . $ruta_noticia . '?n=' . $row['noticia_url'] . '" target="_blanck">
                                <i class="fa fa-eye fa-2x text-muted cursor-pointer" aria-hidden="true" style="font-size: 20px;"></i>
                            </a>
                        </td>
                    </tr>
                    ';
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Fecha</th>
                            <th>Titulo</th>
                            <th>Sub-Titulo</th>
                            <th>Pais</th>
                            <th>Acciones</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
</div>

<script src="<?= $ruta_inicio ?>V/js/notiluz-noticia.js"></script>