$(document).ready( function () {
    $("#btnGuardar").click(function(){
        // banderas de verificacion
        var pacienteExistente = true;
        var verificacionInputs = true;
        var camaOcupada = true;
        // inputs
        var pacienteDNI = $('select[name="pacienteId"]').val(); // requerido
        var camaId = $('select[name="camaId"]').val();  // requerido
        var diagnostico = $('#diagnosticoId').val();   // requerido
        var observaciones = $('#observacionesId').val();   
        var tipoPaciente = $('select[name="tipoPacienteId"]').val();    // requerido
        var acompaniante = $('#acompanianteId').val();
        var relevamientoId = $('#relevamientoId').val();
        var userId = $('#usuarioId').val();
        if($("#acompanianteId").is(':checked')) {  
            acompaniante = 1; 
        } else {  
            acompaniante = 0;   
        }  

        if(pacienteDNI != "" && camaId != "" && diagnostico != "" && tipoPaciente != ""){
            verificacionInputs = true;
        }else{
            verificacionInputs = false;
        }
        $('#labelComprobar').removeClass('alert-success alert-danger');
        $('#labelComprobar').fadeIn();
        $('#labelComprobar').text("");

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
        if(verificacionInputs == true){
            $('#btnGuardar').attr('disabled',true);
            $.ajax({
                type:'GET',
                url:"../getDetallesRelevamiento/"+relevamientoId,
                dataType:"json",
                beforeSend: function(response){
                $("#labelComprobar").text("Verificando datos...");
                },
            success: function(response) {
                    $("#labelComprobar").text("");
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
                        ajaxPost(relevamientoId,pacienteDNI,camaId,diagnostico,observaciones,tipoPaciente,acompaniante,pacienteExistente,camaOcupada,userId);
                    }
                    else{
                        $('#btnGuardar').attr('disabled',false);
                        if (pacienteExistente == false && camaOcupada == false) {
                            $('#modalValidacionDetalleRelevamiento').empty();
                            $('#modalValidacionDetalleRelevamiento').append('<input type="hidden" id="pacienteExistente" value="false">');
                            $('#modalValidacionDetalleRelevamiento').append('<input type="hidden" id="camaOcupada" value="false">');
                            $('#modalValidacionDetalleRelevamiento').append('El paciente seleccionado ya esta activo en la cama: '+pacienteExistente_Cama + '. <br>' );
                            $('#modalValidacionDetalleRelevamiento').append('La cama seleccionada esta siendo ocupada por: ' + camaOcupada_Paciente + '. ¿Continuar de todas formas?');
                            $('#modalPrueba').modal('show');
                            
                        }else{
                            if(pacienteExistente == false){
                                $('#modalValidacionDetalleRelevamiento').empty();
                                $('#modalValidacionDetalleRelevamiento').append('<input type="hidden" id="pacienteExistente" value="false">');
                                $('#modalValidacionDetalleRelevamiento').append('<input type="hidden" id="camaOcupada" value="true">');
                                $('#modalValidacionDetalleRelevamiento').append('El paciente seleccionado ya esta activo en la cama: '+pacienteExistente_Cama + '. ¿Continuar de todas formas?');
                                $('#modalPrueba').modal('show');
                            }
                            else{
                                if (camaOcupada == false) {
                                    $('#modalValidacionDetalleRelevamiento').empty();
                                    $('#modalValidacionDetalleRelevamiento').append('<input type="hidden" id="camaOcupada" value="false">');
                                    $('#modalValidacionDetalleRelevamiento').append('<input type="hidden" id="pacienteExistente" value="true">');
                                    $('#modalValidacionDetalleRelevamiento').append('La cama seleccionada esta siendo ocupada por: ' + camaOcupada_Paciente + '. ¿Continuar de todas formas?');
                                    $('#modalPrueba').modal('show');
                                }
                            }
                        }
                    }
                },
                error:function(){
                    $("#labelComprobar").text("ERROR 1");
                    devolver = false;
                }
            });
        }else{
            $("#labelComprobar").text("Verifique los campos.");
        }
    });

    $("#btnAgregar").click(function(){
    $('#labelNombre').removeClass('text-danger');
    $('#labelNombre').text('Nombre');
    $('#alimentoNombre').val("");
    $('#btnGuardar').attr('disabled',false);
    });   
    
    $("button[data-number=1]").click(function(){
        $('#modalAgregarDetalleRelevamiento').modal('hide');
    });
    
    $("button[data-number=2]").click(function(){
        $('#modalPrueba').modal('hide');
    });
    
    $('#btnValidar').click(function() {
        // banderas de verificacion
        $('#modalPrueba').modal('hide');
        $('#modalAgregarDetalleRelevamiento').modal('hide');
        var pacienteExistente = $('#pacienteExistente').val();
        var camaOcupada =  $('#camaOcupada').val();
        // inputs
        var pacienteDNI = $('select[name="pacienteId"]').val(); // requerido
        var camaId = $('select[name="camaId"]').val();  // requerido
        var diagnostico = $('#diagnosticoId').val();   // requerido
        var observaciones = $('#observacionesId').val();   
        var tipoPaciente = $('select[name="tipoPacienteId"]').val();    // requerido
        var acompaniante = $('#acompanianteId').val();
        var relevamientoId = $('#relevamientoId').val();
        var userId = $('#usuarioId').val();

        if($("#acompanianteId").is(':checked')) {  
            acompaniante = 1; 
        } else {  
            acompaniante = 0;   
        }  
        ajaxPost(relevamientoId,pacienteDNI,camaId,diagnostico,observaciones,tipoPaciente,acompaniante,pacienteExistente,camaOcupada,userId);
    });
    $('#ultimoRelevamientoId').click(function() {
        var pacienteId = $('#pacienteId option:selected').val();
        if(pacienteId != ""){
            $.ajax({
                type:'GET',
                url:"../api/detallesrelevamiento/"+pacienteId,
                dataType:"json",
                success: function(response){
                    
                    if(response.detalleRelevamiento != null){
                        $("#respuestaUltimoRelevamiento").text("Relevamiento encontrado");
                        $('#camaId').val(response.detalleRelevamiento.CamaId).trigger('change');
                        $('#diagnosticoId').text(response.detalleRelevamiento.DetalleRelevamientoDiagnostico);  
                        $('#observacionesId').text(response.detalleRelevamiento.DetalleRelevamientoObservaciones);  
                        $('#tipoPacienteId').val(response.detalleRelevamiento.TipoPacienteId).trigger('change');
                        if(response.detalleRelevamiento.DetalleRelevamientoAcompaniante == 1){
                            $('#acompanianteId').prop("checked", true);
                        }else{
                            $('#acompanianteId').prop("checked", false);
                        }
                    }else{
                        $("#respuestaUltimoRelevamiento").text("Sin relevamientos previos");
                        $('#camaId').val(null).trigger('change');
                        $('#diagnosticoId').text("");  
                        $('#observacionesId').text("");  
                        $('#tipoPacienteId').val(null).trigger('change');
                        $('#acompanianteId').prop("checked", false);
                    }
                },
                error:function(){
                    $("#labelComprobar").text("ERROR 3");
                }
            });
        }else{
            $("#labelComprobar").text("Seleccione un paciente.");
        }
    });
    $('#pacienteId').select2({
        width: 'resolve',
        theme: "classic",
        placeholder: "Buscar por Nombre o DNI",
        allowClear: true
      });
    $('#camaId').select2({
        width: 'resolve',
        theme: "classic",
        placeholder: 'Buscar por "Sala/Pieza/Cama"',
        allowClear: true,
    });
    $('#tipoPacienteId').select2({
        width: 'resolve',
        theme: "classic",
        placeholder: 'Buscar por Tipo de Paciente',
        allowClear: true,
    });
    
});

function ajaxPost(relevamientoId,pacienteDNI,camaId,diagnostico,observaciones,tipoPaciente,acompaniante,pacienteExistente,camaOcupada,usuarioId) {
    $.ajax({
        type:'POST',
        url:"../detallesrelevamiento",
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
            $('#modalAgregarDetalleRelevamiento').modal('hide');
            $('#divMensaje').addClass('alert-success');
            $('#divMensaje').text("Registro agregado");
            $('#divMensaje').fadeOut(4000);
            var table = $('#tableDetallesRelevamiento').DataTable();
            table.draw();
            },
        error:function(){
        $("#labelComprobar").text("ERROR 2");
        }
    });
}