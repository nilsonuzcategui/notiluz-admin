$(document).ready(function () {
    $('.js-example-basic-multiple').select2();
    $('.js-example-basic-single').select2();

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
                url: "https://notiluz.com/apis/noticias.php",
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

                    // location.reload();
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

});