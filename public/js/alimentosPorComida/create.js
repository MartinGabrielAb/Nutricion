$( document ).ready(function() {
    $("#btnGuardar").click(function(){
        var verificacion = true;
        var verificacionCantidadNeto = true;
        if($('select[name="alimentoId"]').val() != "" && $('input[name="cantidadNeto"]').val() != "" && $('select[name="selectUnidadMedida"]').val() != ""){
          verificacion = true;
          if($('input[name="cantidadNeto"]').val() < 0 || isNaN($('input[name="cantidadNeto"]').val())){
            verificacionCantidadNeto = false ;
          }else{
            verificacionCantidadNeto = true ;
          }
        }else{
          verificacion = false;
        }
        id = $('#alimento').val();
        $('#labelComprobar').removeClass('alert-success alert-danger');
        $('#labelComprobar').fadeIn();
        $('#labelComprobar').text("");

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
        if(verificacion == true && verificacionCantidadNeto == true ){
          $('#btnGuardar').attr('disabled',true);
          $.ajax({
            type:'GET',
            url:"../api/nutrientesPorAlimento/"+id,
            dataType:"json",
            beforeSend: function(response){
              $("#labelComprobar").text("Verificando datos...");
            },
          success: function(response) {
              $("#labelComprobar").text("");
              if(response == 1){
                  devolver = true;
              }else{
                  devolver = false;
              }
              if(devolver == true){
                    $.ajax({
                    type:'POST',
                    url:"../alimentosporcomida",
                    dataType:"json",
                    data:{
                      comidaId : $('input[name="comidaId"]').val(),
                      alimentoId : $('select[name="alimentoId"]').val(),
                      cantidadNeto: $('input[name="cantidadNeto"]').val(),
                      unidadMedida : $('input[name="unidadMedida"]').val(),
                    },
                    success: function(response){
                        $('#modalAgregar').modal('hide');
                        $('#divMensaje').addClass('alert-success');
                        $('#divMensaje').text("Registro agregado");
                        $('#divMensaje').fadeOut(4000);
                        $('#alimentoNombre').val("");
                        var table = $('#tableAlimentosPorComida').DataTable();
                        table.draw();
                        },
                    error:function(){
                      $("#labelComprobar").text("ERROR 2");
                    }
                  });
                }
                else{
                  $('#btnGuardar').attr('disabled',false);
                  $("#labelComprobar").text("El alimento seleccionado no tiene los nutrientes cargados");
                }
            },
            error:function(){
              $("#labelComprobar").text("ERROR 1");
              devolver = false;
            }
          });
        }else{
          if(verificacionCantidadNeto == false){
            $("#labelComprobar").text("La cantidad debe ser un número positivo");
          }
          else{
            $("#labelComprobar").text("Verifique los campos");
          }
        }
      });
  
    $("#btnAgregar").click(function(){
      $('#labelNombre').removeClass('text-danger');
      $('#btnGuardar').attr('disabled',false);
    });   



    $('#option1').hide();
    $('#option2').hide();
    $('#option3').hide();
    $('.js-example-basic-single').select2();
    $('#alimento').select2({
      width: 'resolve',
      theme: "classic",
      placeholder: "Alimentos",
      allowClear: true
    });
  });
  function habilitarUnidadesMedida(unidadesMedida,alimentos){
    var alimentoId = $('select[name="alimentoId"] option:selected').val();
    for (var item in alimentos) {
        if (alimentos[ item ].AlimentoId == alimentoId) {
              var unidadMedidaId = alimentos[item].UnidadMedidaId; 
                
        }
    }
    for (var unidad in unidadesMedida) {
        if(unidadMedidaId == unidadesMedida[unidad].UnidadMedidaId){
            var unidadMedida = unidadesMedida[unidad].UnidadMedidaNombre;
            if(unidadMedida == 'Litro' || unidadMedida == 'Mililitro' || unidadMedida == 'Kilolitro'){
                    var esVisibleOption2 = $("#option2").is(":visible");
                    var esVisibleOption3 = $("#option3").is(":visible");
                    if(!esVisibleOption2 && !esVisibleOption3){
                            $('#option1').show();
                            $('#option2').show();
                            $('#option3').show();
                    }
                    $('#option1').val("Litro");
                    $('#option2').val("Mililitro");
                    $('#option3').val("Kilolitro");
                    $('#option1').text("Litro");
                    $('#option2').text("Mililitro");
                    $('#option3').text("Kilolitro");
            }
            if(unidadMedida == 'Gramo' || unidadMedida == 'Kilogramo' || unidadMedida == 'Miligramo'){
                    var esVisibleOption2 = $("#option2").is(":visible");
                    var esVisibleOption3 = $("#option3").is(":visible");
                    if(!esVisibleOption2 && !esVisibleOption3){
                            $('#option1').show();
                            $('#option2').show();
                            $('#option3').show();
                    }
                    $('#option1').val("Gramo");
                    $('#option2').val("Kilogramo");
                    $('#option3').val("Miligramo");
                    $('#option1').text("Gramo");
                    $('#option2').text("Kilogramo");
                    $('#option3').text("Miligramo");
            }
            if(unidadMedida == "Unidad"){
                    $('#option1').val("Unidad");
                    $('#option1').text("Unidad");
                    $('#option1').show();
                    $('#option2').hide();
                    $('#option3').hide();
            }
            //$('.unidadMedida').text(unidadesMedida[unidad].UnidadMedidaNombre);

        }
    }
  }