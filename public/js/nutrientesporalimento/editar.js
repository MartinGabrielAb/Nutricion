function editarNutrientePorAlimento(id){
    var devolver = true;
    var verificacion = true;
    var verificacionValor = true;
    console.log($('#valor'+id).val());
    if($('#nutrienteId'+id).val() != "" && $('#valor'+id).val() != ""){
        verificacion = true;
        if($('#valor'+id).val() < 0 || isNaN($('#valor'+id).val())){
            verificacionValor = false ;
        }else{
            verificacionValor = true ;
        }
    }else{
        verificacion = false;
    }
    $('#labelComprobar'+id).removeClass('alert-success alert-danger');
    $('#labelComprobar'+id).fadeIn();
    $('#labelComprobar'+id).text("");

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });
    if(verificacion == true && verificacionValor == true ){
        $('#btnGuardar'+id).attr('disabled',true);
        $.ajax({
        type:'GET',
        url:"../getNutrientesPorAlimento",
        dataType:"json",
        beforeSend: function(response){
            $('#labelComprobar'+id).text("Verificando datos...");
        },
        success: function(response) {
            $('#labelComprobar'+id).text("");
            console.log(id);
            for (nutrientePorAlimento in response.nutrientesPorAlimento) {
                if($('#alimentoId'+id).val() == response.nutrientesPorAlimento[nutrientePorAlimento].AlimentoId && response.nutrientesPorAlimento[nutrientePorAlimento].NutrienteId == $('#nutrienteId'+id).val()) {
                    devolver = false;
                }
            }
            if(devolver == true){
                $.ajax({
                type:'PUT',
                url:"../nutrientesporalimento/"+id,
                dataType:"json",
                data:{
                    alimentoId : $('#alimentoId'+id).val(),
                    nutrienteId : $('#nutrienteId'+id).val(),
                    valor : $('#valor'+id).val(),
                },
                success: function(response){
                    $('#modalEditar'+id).modal('hide');
                    $('#divMensaje').addClass('alert-success');
                    $('#divMensaje').text("Registro editado");
                    $('#divMensaje').fadeOut(4000);
                    var table = $('#tableNutrientesPorAlimento').DataTable();
                    table.draw();
                    },
                error:function(){
                    $('#labelComprobar'+id).text("ERROR 2");
                }
                });
            }
            else{
                $('#btnGuardar'+id).attr('disabled',false);
                $('#labelComprobar'+id).text("El nutriente seleccionado ya está cargado");
            }
        },
        error:function(){
            $('#labelComprobar'+id).text("ERROR 1");
            devolver = false;
        }
        });
    }else{
        if(verificacionValor == false){
        $('#labelComprobar'+id).text("La cantidad debe ser un número positivo");
        }
        else{
        $('#labelComprobar'+id).text("Verifique los campos");
        }
    }
}

$(".btnEditarNutriente").click(function(){
    id = $(this).data('id');
    $('#nutrienteId'+id).val(null).trigger('change');
    $('#valor'+id).val("");
    $('#nutrienteUnidadMedidaId'+id).text("");
    $('#btnGuardar'+id).attr('disabled',false);
    $('#labelComprobar'+id).empty();
});   

$('.nutrientesPorAlimentoSelect').select2({
    width: 'resolve',
    theme: "classic",
    placeholder: "Nutrientes",
    allowClear: true
});
function determinarUnidadMedida(nutrientes,unidadesMedida,id) {
    nutrienteId = $("#nutrienteId"+id).val();
    for (let i = 0; i < nutrientes.length; i++) {
        if(nutrientes[i].NutrienteId == nutrienteId){
            var unidadMedidaId = nutrientes[i].UnidadMedidaId;
        }        
    }
    if (unidadMedidaId) {
        for (let i = 0; i < unidadesMedida.length; i++) {
            if(unidadesMedida[i].UnidadMedidaId == unidadMedidaId){
                unidadMedidaNombre = unidadesMedida[i].UnidadMedidaNombre;
                $('#nutrienteUnidadMedidaId'+id).text(unidadMedidaNombre);
            }        
        }    
    }
}