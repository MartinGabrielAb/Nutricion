var validarNombreComida = true;
function editarComida(id){
    var nombreComida = $("#nombreComida"+id).val();
    if(nombreComida == ""){
        validarNombreComida = false;
    }
    $('#divMensaje').removeClass('alert-success alert-danger');
    $('#divMensaje').fadeIn();
    $('#divMensaje').text("");
    $('#labelComprobar'+id).removeClass('alert-success alert-danger');
    $('#labelComprobar'+id).fadeIn();
    $('#labelComprobar'+id).text("");
    $('#btnGuardar'+id).attr('disabled',true);
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });
    $.ajax({
        type:'GET',
        url:"getComidas",
        dataType:"json",
        beforeSend: function(response){
          $("#labelComprobar"+id).text("Verificando datos...");
        },
        success: function(response) {
            $("#labelComprobar"+id).text("");
            var nombre = $('#nombreComida'+id).val();
            var tipoComida = $('#tipoComida'+id).val();
            var devolver = true;
            for (let index = 0; index < response.comidas.length; index++){
                if(response.comidas[index]['ComidaNombre'] == nombre && response.comidas[index]['TipoComidaId'] == tipoComida){
                    devolver = false;
                    $("#labelNombre"+id).addClass('text-danger');
                    $("#labelNombre"+id).text("La comida ingresada ya existe");
                    break;
                }
            }
            if(devolver == true && validarNombreComida == true){
                $.ajax({
                    type:'PUT',
                    url:"comidas/"+id,
                    dataType:"json",
                    data:{
                      nombreComida: $('#nombreComida'+id).val(),
                      tipoComida : $('#tipoComida'+id).val(),
                    },
                    success: function(response){
                        $('#modalEditar'+id).modal('hide');
                        $('#divMensaje').addClass('alert-success');
                        $('#divMensaje').text("Registro editado");
                        $('#divMensaje').fadeOut(4000);
                        $('#nombreComida'+id).val("");
                        $('#tipoComida'+id).val("");
                        var table = $('#tableComidas').DataTable();
                        table.draw();
                        },
                    error:function(){
                      $("#labelComprobar"+id).text("Error 2");
                    }
                });
            }else{
                $('#labelComprobar'+id).addClass('alert alert-danger');
                $('#labelComprobar'+id).text('Verifique los campos.');
            }
        },
        error:function(){
          $("#labelComprobar"+id).text("ERROR 1");
          devolver = false;
        }
      });
}
$( document ).ready(function() {
    $('body').on('focus', '.nombreComida', function(){
        var id = $(this).data('id');
        $('#btnGuardar'+id).attr('disabled',false);
        $("#labelComprobar"+id).empty().removeClass('alert alert-danger');
        $("#labelNombre"+id).removeClass('text-danger');
        $("#labelNombre"+id).empty();
      });
      $('body').on('blur', '.nombreComida', function(){
        var id = $(this).data('id');
        var nombreComida = $(this).val();
        if(nombreComida == undefined ){
            validarNombreComida = false;
        }else{
            validarNombreComida = true;
        }
      });
});