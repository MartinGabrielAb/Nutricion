$( document ).ready(function() {
    $("#btnGuardar").click(function(){
        var validarFechaTurno = true;
        var relevamientoFecha = $("#relevamientoFechaId").val();
        var relevamientoTurno = $("#relevamientoTurnoId").val();
        if(relevamientoFecha == "" || relevamientoTurno == ""){
            validarFechaTurno = false;
        }
        $('#labelComprobar').removeClass('alert-success alert-danger');
        $('#labelComprobar').fadeIn();
        $('#labelComprobar').text("");
        
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
        if(validarFechaTurno == true){
            $('#btnGuardar').attr('disabled',true);
            $.ajax({    
            type:'GET',
            url:"getRelevamientos",
            dataType:"json",
            beforeSend: function(response){
                $("#labelComprobar").text("Verificando datos...");
            },
            success: function(response) {
                $("#labelComprobar").text("");
                var devolver = true;
                for (let index = 0; index < response.relevamientos.length; index++){
                    if(response.relevamientos[index]['RelevamientoFecha'] == relevamientoFecha && response.relevamientos[index]['RelevamientoTurno'] == relevamientoTurno){
                        devolver = false;
                        break;
                    }
                }
                if(devolver == true){
                    $.ajax({
                        type:'POST',
                        url:"relevamientos",
                        dataType:"json",
                        data:{
                            fecha: relevamientoFecha,
                            turno: relevamientoTurno,
                        },
                        success: function(response){
                            $('#modalAgregar').modal('hide');
                            $('#divMensaje').removeAttr('style');
                            $('#divMensaje').addClass('alert-success');
                            $('#divMensaje').text("Registro agregado");
                            $('#divMensaje').fadeOut(4000);
                            var table = $('#tableRelevamientos').DataTable();
                            table.draw();
                            },
                        error:function(){
                            $("#labelNombre").text("Error 2");
                            $("#labelNombre").addClass('text-danger');
                        }
                    });
                }else{
                    $('#labelComprobar').addClass('alert alert-danger');
                    $('#labelComprobar').text('El relevamiento ya existe');
                }
            },
            error:function(){
                $("#labelComprobar").text("ERROR 1");
                devolver = false;
            }
            });
        }else{
            $("#labelComprobar").text("Verifique los campos");
        }
    });
    $('#relevamientoTurnoId').select2({
        width: 'resolve',
        theme: "classic",
        placeholder: "Turno",
        allowClear: true
    });

    $("#btnAgregar").click(function(){
      $('#labelNombre').removeClass('text-danger');
      $('#relevamientoFechaId').val("");
      $('#relevamientoTurnoId').val("");
      $('#relevamientoFechaId').val("Fecha");
      $('#btnGuardar').attr('disabled',false);
      $("#labelComprobar").empty();
      $('#labelComprobar').removeClass('alert-danger');
    });   
    $("#relevamientoFechaId").focus(function(){
        $('#labelNombre').removeClass('text-danger');
        $('#labelNombre').text('Fecha');
        $('#labelComprobar').removeClass('alert-danger');
        $("#labelComprobar").empty();
        $('#btnGuardar').attr('disabled',false);
      }); 
    $("#relevamientoTurnoId").change(function(){
        $('#labelNombre').removeClass('text-danger');
        $('#labelNombre').text('Fecha');
        $('#labelComprobar').removeClass('alert-danger');
        $("#labelComprobar").empty();
        $('#btnGuardar').attr('disabled',false);
    });
  });
  function seleccionarmenu_advertencia($relevamientoId){
    $('#modalSeleccionarMenuAdvertencia'+$relevamientoId).modal('show');
  }