$(document).ready( function () {
    // $("button[data-number=1]").click(function(){
    //     $('#modalAgregarDetalleRelevamiento').modal('hide');
    // });
    $('body').on('click', '.cerrarModalEditarValidaciones', function(){
        id = $(this).data('id');
        $('#modalPrueba'+id).modal('hide');
    });
    $('body').on('click', '.btnValidar', function(){
        id = $(this).data('id');
        // banderas de verificacion
        $('#modalPrueba'+id).modal('hide');
        $('#modalAgregarDetalleRelevamiento'+id).modal('hide');
        var pacienteExistente = $('#pacienteExistente'+id).val();
        var camaOcupada =  $('#camaOcupada'+id).val();
        // inputs
        var pacienteDNI = $('#pacienteId'+id).val(); // requerido
        var camaId = $('#camaId'+id).val();  // requerido
        var diagnostico = $('#diagnosticoId'+id).val();   // requerido
        var observaciones = $('#observacionesId'+id).val();   
        var tipoPaciente = $('#tipoPacienteId'+id).val();    // requerido
        var acompaniante = $('#acompanianteId'+id).val();
        var relevamientoId = $('#relevamientoId').val();
        var usuarioId = $('#usuarioId').val();
        if($("#acompanianteId"+id).is(':checked')) {  
            acompaniante = 1; 
        } else {  
            acompaniante = 0;   
        }  
        ajaxPut(relevamientoId,pacienteDNI,camaId,diagnostico,observaciones,tipoPaciente,acompaniante,pacienteExistente,camaOcupada,id,usuarioId);
    });
    // $('#ultimoRelevamientoId').click(function() {
    //     var pacienteId = $('#pacienteId option:selected').val();
    //     if(pacienteId != ""){
    //         $.ajax({
    //             type:'GET',
    //             url:"../api/detallesrelevamiento/"+pacienteId,
    //             dataType:"json",
    //             success: function(response){
                    
    //                 if(response.detalleRelevamiento != null){
    //                     $("#respuestaUltimoRelevamiento").text("Relevamiento encontrado");
    //                     $('#camaId').val(response.detalleRelevamiento.CamaId).trigger('change');
    //                     $('#diagnosticoId').text(response.detalleRelevamiento.DetalleRelevamientoDiagnostico);  
    //                     $('#observacionesId').text(response.detalleRelevamiento.DetalleRelevamientoObservaciones);  
    //                     $('#tipoPacienteId').val(response.detalleRelevamiento.TipoPacienteId).trigger('change');
    //                     if(response.detalleRelevamiento.DetalleRelevamientoAcompaniante == 1){
    //                         $('#acompanianteId').prop("checked", true);
    //                     }else{
    //                         $('#acompanianteId').prop("checked", false);
    //                     }
    //                 }else{
    //                     $("#respuestaUltimoRelevamiento").text("Sin relevamientos previos");
    //                     $('#camaId').val(null).trigger('change');
    //                     $('#diagnosticoId').text("");  
    //                     $('#observacionesId').text("");  
    //                     $('#tipoPacienteId').val(null).trigger('change');
    //                     $('#acompanianteId').prop("checked", false);
    //                 }
    //             },
    //             error:function(){
    //                 $("#labelComprobar").text("ERROR 3");
    //             }
    //         });
    //     }else{
    //         $("#labelComprobar").text("Seleccione un paciente.");
    //     }
    // });
});
function editarDetalleRelevamiento(id){
    // banderas de verificacion
    var pacienteExistente = true;
    var verificacionInputs = true;
    var camaOcupada = true;
    // inputs
    var pacienteDNI = $('#pacienteId'+id).val(); // requerido
    var camaId = $('#camaId'+id).val();  // requerido
    var diagnostico = $('#diagnosticoId'+id).val();   // requerido
    var observaciones = $('#observacionesId'+id).val();   
    var tipoPaciente = $('#tipoPacienteId'+id).val();    // requerido
    var acompaniante = $('#acompanianteId'+id).val();
    var relevamientoId = $('#relevamientoId').val();
    var usuarioId = $('#usuarioId').val();

    if($("#acompanianteId"+id).is(':checked')) {  
        acompaniante = 1; 
    } else {  
        acompaniante = 0;   
    }  

    if(pacienteDNI != "" && camaId != "" && diagnostico != "" && tipoPaciente != ""){
        verificacionInputs = true;
    }else{
        verificacionInputs = false;
    }
    $('#labelComprobar'+id).removeClass('alert-success alert-danger');
    $('#labelComprobar'+id).fadeIn();
    $('#labelComprobar'+id).text("");

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });
    if(verificacionInputs == true){
        $('#btnGuardar'+id).attr('disabled',true);
        $.ajax({
            type:'GET',
            url:"../getDetallesRelevamiento/"+relevamientoId,
            dataType:"json",
            beforeSend: function(response){
            $("#labelComprobar"+id).text("Verificando datos...");
            },
        success: function(response) {
                $("#labelComprobar"+id).text("");
                for (detalleRelevamiento in response.detallesRelevamiento) {
                    if(pacienteDNI == response.detallesRelevamiento[detalleRelevamiento].PersonaCuil) {
                        pacienteExistente = false;
                        pacienteExistente_Cama = response.detallesRelevamiento[detalleRelevamiento].SalaNombre+'/'+response.detallesRelevamiento[detalleRelevamiento].PiezaNombre+'/'+response.detallesRelevamiento[detalleRelevamiento].CamaNumero ;
                    }                            
                    if (camaId == response.detallesRelevamiento[detalleRelevamiento].CamaId) {
                        camaOcupada = false;
                        camaOcupada_Paciente = response.detallesRelevamiento[detalleRelevamiento].PersonaApellido + ', ' + response.detallesRelevamiento[detalleRelevamiento].PersonaNombre
                    }
                }
                if(pacienteExistente == true && camaOcupada == true){
                    ajaxPut(relevamientoId,pacienteDNI,camaId,diagnostico,observaciones,tipoPaciente,acompaniante,pacienteExistente,camaOcupada,id,usuarioId);
                }
                else{
                    $('#btnGuardar'+id).attr('disabled',false);
                    if (pacienteExistente == false && camaOcupada == false) {
                        $('#modalValidacionDetalleRelevamiento'+id).empty();
                        $('#modalValidacionDetalleRelevamiento'+id).append('<input type="hidden" id="pacienteExistente'+id+'" value="false">');
                        $('#modalValidacionDetalleRelevamiento'+id).append('<input type="hidden" id="camaOcupada'+id+'" value="false">');
                        $('#modalValidacionDetalleRelevamiento'+id).append('El paciente seleccionado ya esta activo en la cama: '+pacienteExistente_Cama + '. <br>' );
                        $('#modalValidacionDetalleRelevamiento'+id).append('La cama seleccionada esta siendo ocupada por: ' + camaOcupada_Paciente + '. ¿Continuar de todas formas?');
                        $('#modalPrueba'+id).modal('show');
                    }else{
                        if(pacienteExistente == false){
                            $('#modalValidacionDetalleRelevamiento'+id).empty();
                            $('#modalValidacionDetalleRelevamiento'+id).append('<input type="hidden" id="pacienteExistente'+id+'" value="false">');
                            $('#modalValidacionDetalleRelevamiento'+id).append('<input type="hidden" id="camaOcupada'+id+'" value="true">');
                            $('#modalValidacionDetalleRelevamiento'+id).append('El paciente seleccionado ya esta activo en la cama: '+pacienteExistente_Cama + '. ¿Continuar de todas formas?');
                            $('#modalPrueba'+id).modal('show');
                        }
                        else{
                            if (camaOcupada == false) {
                                $('#modalValidacionDetalleRelevamiento'+id).empty();
                                $('#modalValidacionDetalleRelevamiento'+id).append('<input type="hidden" id="camaOcupada'+id+'" value="false">');
                                $('#modalValidacionDetalleRelevamiento'+id).append('<input type="hidden" id="pacienteExistente'+id+'" value="true">');
                                $('#modalValidacionDetalleRelevamiento'+id).append('La cama seleccionada esta siendo ocupada por: ' + camaOcupada_Paciente + '. ¿Continuar de todas formas?');
                                $('#modalPrueba'+id).modal('show');
                            }
                        }
                    }
                }
            },
            error:function(){
                $("#labelComprobar"+id).text("ERROR 1");
                devolver = false;
            }
        });
    }else{
        $("#labelComprobar"+id).text("Verifique los campos.");
    }
}
function ajaxPut(relevamientoId,pacienteDNI,camaId,diagnostico,observaciones,tipoPaciente,acompaniante,pacienteExistente,camaOcupada,id,usuarioId) {
    $.ajax({
        type:'PUT',
        url:"../detallesrelevamiento/"+id,
        dataType:"json",
        data:{
            relevamientoId : relevamientoId,
            pacienteDNI : pacienteDNI,
            camaId : camaId,
            diagnostico : diagnostico,
            observaciones : observaciones,
            tipoPacienteId : tipoPaciente,
            acompaniante : acompaniante,
            pacienteExistente: pacienteExistente,
            camaOcupada: camaOcupada,
            usuarioId: usuarioId,
        },
        success: function(response){
            $('#modalEditarDetalleRelevamiento'+id).modal('hide');
            $('#divMensaje'+id).addClass('alert-success');
            $('#divMensaje'+id).text("Registro editado");
            $('#divMensaje'+id).fadeOut(4000);
            var table = $('#tableDetallesRelevamiento').DataTable();
            table.draw();
            },
        error:function(){
        $("#labelComprobar"+id).text("ERROR 2");
        }
    });
}
function cargarSelect2(id) {
    $('#pacienteId'+id).select2({
        width: 'resolve',
        theme: "classic",
        placeholder: 'Buscar por "Sala/Pieza/Cama"',
        allowClear: true,
    });
    $('#camaId'+id).select2({
        width: 'resolve',
        theme: "classic",
        placeholder: 'Buscar por "Sala/Pieza/Cama"',
        allowClear: true,
    });
    $('#tipoPacienteId'+id).select2({
        width: 'resolve',
        theme: "classic",
        placeholder: 'Buscar por Tipo de Paciente',
        allowClear: true,
    });
}