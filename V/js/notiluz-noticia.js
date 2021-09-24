$(document).ready(function () {
    $('.js-example-basic-multiple').select2();
    $('.js-example-basic-single').select2();

    $('#dtBasicExample').DataTable();
    $('.dataTables_length').addClass('bs-select');

    // MOSTRAR IMAGEN DINAMICAMENTE *********************************
    $(".input_file").change(function (e) {
        var labelid = $(this).data('viewlabel');

        var columnabd = $(this).data('bd');
        filePreview(this, labelid, columnabd);
    });
    function filePreview(input, labelid, columnabd) {
        var formData = new FormData();
        var files = input.files[0];

        var reader = new FileReader();
        reader.onload = function (e) {
            $('#' + labelid + ' .vista_file').html('<img src="' + e.target.result + '"/>');
        }
        reader.readAsDataURL(input.files[0]);
    }
    // FIN MOSTRAR IMAGEN DINAMICAMENTE ****************************************************



    // AGREGAR NOTICIA DEL FORM ************************************
    $("#add-noticia").on("submit", function (e) {
        e.preventDefault();

        var f = $(this);
        console.log(f);
        if (true) {
            $('#botonForm').hide();
            $('#loadingForm').show();

            var formData = new FormData(document.getElementById("add-noticia"));
            formData.append(f.attr("name"), $(this)[0].files);

            var valorImportante = 0;
            if (document.getElementById('importante').checked) {
                valorImportante = 1;
            }
            formData.append('importante_edit', valorImportante);

            $.ajax({
                url: "./C/noticias.php",
                type: "post",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            }).done(function (res) {
                if (res['response'] == 'exito') {
                    $('#botonForm').show();
                    $('#loadingForm').hide();

                    location.reload();
                    swal("Exito!", "", "success");
                } else {
                    swal("Error!", "No se pudo Agregar o Editar la notcia", "error");
                    $('#botonForm').show();
                    $('#loadingForm').hide();
                }
            });

        } else {
            swal("Ups!", "Es necesario asignar un Banner y una imagen", "warning");
        }
    });
    // FIN AGREGAR NOTICIA DEL FORM ************************************************************************


    // EDITAR NOTICIA **************************************************************
    $("#dtBasicExample").on("click", ".editar_noticia", function () {
        var idnoticia = $(this).data('id');
        $.ajax({
            type: "POST",
            url: "../apis/noticias.php",
            data: {
                opt: 'buscar_noticia',
                idnoticia: idnoticia,
            },
            dataType: "json",
        }).done(function (data) {
            if (data['response'] == 'exito') {
                // LLENAR EL FORMULARIO
                var datos = data['arrayAux'];
                $('#idnoticia').val(datos['idnoticia']);
                $('#fecha').val(datos['fecha']);
                $('#titulo').val(datos['titulo']);
                $('#subtitulo').val(datos['subtitulo']);
                $('#subtitulo').val(datos['subtitulo']);
                $('#contenido').val(datos['contenido']);
                $('#pais').val(datos['pais']).trigger('change');
                $('.js-example-basic-multiple').val(data['arrayEtiquetas']).trigger('change');
                // INTRODUCIR FOTOS
                $('#label_logo_1 .vista_file').html('<img src="../apis/imagenes/' + datos['baner'] + '"/>');

                $('#label_logo_2 .vista_file').html('<img src="../apis/imagenes/' + datos['imagen'] + '"/>');

                // LLEVAR HACIA ARRIBA
                $('html, body').animate({
                    scrollTop: 0
                }, 600);
            } else {
                swal("Lo siento!", "No Se Pudo Procesar los Datos!", "error");
            }
            $('.limpiar_form').click();
        }).fail(function (jqXHR, textStatus, errorThrown) {
            if (console && console.log) {
                console.log("La solicitud a fallado: " + textStatus);
            }
            swal("Disculpe!", "Asegurese de tener una buena conexion a internet!", "warning");
        });
    });





    //ELIMINAR UNA NOTICIA *******************************************
    $("#dtBasicExample").on("click", ".borrar_noticia", function () {
        var idnoticia = $(this).data('id');
        swal({
            title: "Estas Seguro?",
            text: "Una vez eliminado no podra recuperar!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "POST",
                        url: "../apis/noticias.php",
                        data: {
                            opt: 'eliminar_noticia',
                            idnoticia: idnoticia,
                        },
                        dataType: "json",
                    }).done(function (data) {
                        if (data['response'] == 'exito') {
                            swal("Exito!", "Eliminado con exito", "success");
                            location.reload();
                        } else {
                            swal("Lo siento!", "No Se Pudo Procesar los Datos!", "error");
                        }
                        $('.limpiar_form').click();
                    }).fail(function (jqXHR, textStatus, errorThrown) {
                        if (console && console.log) {
                            console.log("La solicitud a fallado: " + textStatus);
                        }
                        swal("Disculpe!", "Asegurese de tener una buena conexion a internet!", "warning");
                    });
                }
            });
    });

});