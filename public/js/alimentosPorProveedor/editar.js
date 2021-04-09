var validacionCantidad = true;
var validacionPrecio = true;
var validacionFecha = false;
function editarAlimentoPorProveedor(id){
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
    if(validacionCantidad == true && validacionPrecio == true){
        $.ajax({
            type:'PUT',
            url:"../alimentosporproveedor/"+id,
            dataType:"json",
            data:{
                alimentoId: $('#alimentoId'+id).val(),
                proveedor: $('#proveedor'+id).val(),
                cantidad: $('#cantidad'+id).val(),
                precio: $('#precio'+id).val(),
                vencimiento: $('#vencimiento'+id).val(),
            },
            success: function(response){
                $('#labelComprobar'+id).addClass('alert-success');
                $('#labelComprobar'+id).text("Registro editado.");
                $('#labelComprobar'+id).fadeOut(4000);
                var table = $('#tableAlimentosPorProveedor').DataTable();
                table.draw();
                $('#modalEditarPorProveedor'+id).modal('hide');
                $('#divMensaje').addClass('alert-success');
                $('#divMensaje').text("Registro editado correctamente.");
                $('#divMensaje').fadeOut(4000);
            },
            error:function(){
                $("#labelComprobar"+id).text("ERROR 2");
            },
        });
    }else{
        $('#labelComprobar'+id).addClass('alert alert-danger');
        $('#labelComprobar'+id).text('Por favor verifique los campos.');
    }

}
    // validacion de campos
$( document ).ready(function() {
    $('body').on('blur', '.cantidad', function(){
        id=$(this).data('id');
        var cantidad = $(this).val();
    if($.isNumeric(cantidad) && cantidad>=0){
        validacionCantidad = true;
        if(validacionPrecio == true && validacionFecha == true){
            $('#btnGuardar'+id).attr('disabled',false);
        }
        $("#cantidad"+id).removeClass('bg-danger');
        $('#labelComprobar'+id).removeClass('alert alert-danger');
        $('#labelComprobar'+id).empty();
    }else{
        validacionCantidad = false;
        $("#cantidad"+id).addClass("bg-danger");
        $('#btnGuardar'+id).attr('disabled',true);
    }
    })
    $('body').on('blur', '.precio', function(){
        id=$(this).data('id');
        var precio = $(this).val();
    if($.isNumeric(precio) && precio>=0){
        validacionPrecio = true;
        if(validacionCantidad == true && validacionFecha == true ){
            $('#btnGuardar'+id).attr('disabled',false);
        }
        $("#precio"+id).removeClass('bg-danger');
        $('#labelComprobar'+id).removeClass('alert alert-danger');
        $('#labelComprobar'+id).empty();
    }else{
        validacionPrecio = false;
        $("#precio"+id).addClass("bg-danger");
        $('#btnGuardar'+id).attr('disabled',true);
    }
    });
    $('body').on('blur', '.fecha', function(){
        id=$(this).data('id');
        esVacio = $.isEmptyObject($(this).val());
        if(!esVacio){
            validacionFecha = true;
            if(validacionCantidad == true && validacionPrecio == true ){
                $('#btnGuardar'+id).attr('disabled',false);
            }
            $(this).removeClass('bg-danger');
            $('#labelComprobar'+id).removeClass('alert alert-danger');
            $('#labelComprobar'+id).empty();
        }else{
            validacionFecha = false;
            $(this).addClass("bg-danger");
            $('#btnGuardar'+id).attr('disabled',true);
        }
    });
});