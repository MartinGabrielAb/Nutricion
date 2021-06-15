$(document).ready( function () {
    //select2
  $('#sala').select2({
    width: 'resolve',
    theme: "classic",
    placeholder: {
          id: '-1', 
          text: "Sala",
        },
    allowClear: true
  });
});

//POST AJAX
function getReporteProduccionRaciones(e){
    $("#listaErrores").empty();
    e.preventDefault();
    $.ajax({
        xhrFields: {
            responseType: 'blob',
        },
        type:'GET',
        url:"../reporte/produccionRaciones",
        // responseType: 'blob',
        data:{
            RelevamientoFechaIni: $('#fecha_desde').val(),
            RelevamientoFechaFin: $('#fecha_hasta').val(),
        },
        success: function(result, status, xhr){
            // mostrarCartel('Registro agregado correctamente.','alert-success');
            var disposition = xhr.getResponseHeader('content-disposition');
            var matches = /"([^"]*)"/.exec(disposition);
            var filename = (matches != null && matches[1] ? matches[1] : 'produccionraciones.xlsx');

            // The actual download
            var blob = new Blob([result], {
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = filename;

            document.body.appendChild(link);

            link.click();
            document.body.removeChild(link);
        },
        error:function(response){
            var errors =  response.responseJSON.errors;
            for (var campo in errors) {
                $("#listaErrores").append('<li type="square">'+errors[campo]+'</li>');
            }       
        }
    });
}
function mostrarCartel(texto,clase){
    $('#divMensaje').stop().removeClass('alert-success alert-danger');
    $('#divMensaje').fadeIn();
    $('#divMensaje').text(texto);
    $('#divMensaje').addClass(clase);  
    $('#divMensaje').fadeOut(4000);
  }