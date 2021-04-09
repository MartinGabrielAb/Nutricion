var validacionCantidad = true;
var validacionPrecio = true;
var validacionFecha = false;
$( document ).ready(function() {
    $("#btnGuardar").click(function(){
        $('#labelComprobar').removeClass('alert alert-danger');
        $('#labelComprobar').fadeIn();
        $('#labelComprobar').text("");
        $('#btnGuardar').attr('disabled',true);
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
        if(validacionCantidad == true && validacionPrecio == true && validacionFecha == true){
            $.ajax({
                type:'POST',
                url:"../alimentosporproveedor",
                dataType:"json",
                data:{
                    alimentoId: $('input[name="alimentoId"]').val(),
                    proveedor : $('select[name="proveedor"]').val(),
                    cantidad : $('input[name="cantidad"]').val(),
                    precio : $('input[name="precio"]').val(),
                    vencimiento : $('input[name="vencimiento"]').val(),
                },
                success: function(response){
                    $('#modalAgregar').modal('hide');
                    $('#divMensaje').addClass('alert-success');
                    $('#divMensaje').text("Registro agregado");
                    $('#divMensaje').fadeOut(4000);
                    $('#alimentoNombre').val("");
                    var table = $('#tableAlimentosPorProveedor').DataTable();
                    table.draw();
                    },
                error:function(){
                    $("#labelComprobar").text("ERROR 2");
                }
            });
        }else{
            $('#labelComprobar').addClass('alert alert-danger');
            $('#labelComprobar').text('Por favor verifique los campos.');
        }
    });
    // validacion de campos
    $("#inputCantidad").blur(function(){
        var cantidad = $(this).val();
        if($.isNumeric(cantidad) && cantidad>=0){
            validacionCantidad = true;
            if(validacionPrecio == true && validacionFecha == true){
                $('#btnGuardar').attr('disabled',false);
            }
            $(this).removeClass('bg-danger');
            $('#labelComprobar').removeClass('alert alert-danger');
            $('#labelComprobar').empty();
        }else{
            validacionCantidad = false;
            $(this).addClass("bg-danger");
            $('#btnGuardar').attr('disabled',true);
        }
    });
    $("#inputCosto").blur(function(){
        id=$(this).data('id');
        var precio = $(this).val();
    if($.isNumeric(precio) && precio>=0){
        validacionPrecio = true;
        if(validacionCantidad == true && validacionFecha == true ){
            $('#btnGuardar').attr('disabled',false);
        }
        $(this).removeClass('bg-danger');
        $('#labelComprobar').removeClass('alert alert-danger');
        $('#labelComprobar').empty();
    }else{
        validacionPrecio = false;
        $(this).addClass("bg-danger");
        $('#btnGuardar').attr('disabled',true);
    }
    });
    $('#inputFecha').blur(function(){
        esVacio = $.isEmptyObject($(this).val());
        if(!esVacio){
            validacionFecha = true;
            if(validacionCantidad == true && validacionPrecio == true ){
                $('#btnGuardar').attr('disabled',false);
            }
            $(this).removeClass('bg-danger');
            $('#labelComprobar').removeClass('alert alert-danger');
            $('#labelComprobar').empty();
        }else{
            validacionFecha = false;
            $(this).addClass("bg-danger");
            $('#btnGuardar').attr('disabled',true);
        }
    });
});