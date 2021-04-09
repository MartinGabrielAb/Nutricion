$( document ).ready(function() {
    $('body').on('click', '.btnEditar', function(){
        var verificacion = true;
        var verificacionCantidadNeto = true;
        var comidaPorAlimentoId = $(this).data('id');
        if($('#alimentosPorComida'+comidaPorAlimentoId).val() != "" && $('#cantidadNeto'+comidaPorAlimentoId).val() != "" && $('#selectUnidadMedida'+comidaPorAlimentoId).val() != ""){
          verificacion = true;
          if($('#cantidadNeto'+comidaPorAlimentoId).val() < 0 || isNaN($('#cantidadNeto'+comidaPorAlimentoId).val())){
            verificacionCantidadNeto = false ;
          }else{
            verificacionCantidadNeto = true ;
          }
        }else{
          verificacion = false;
        }
        $('#labelComprobar').removeClass('alert-success alert-danger');
        $('#labelComprobar').fadeIn();
        $('#labelComprobar').text("");
        alimentoId = $('#alimentosPorComida'+comidaPorAlimentoId).val();
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
        if(verificacion == true && verificacionCantidadNeto == true ){
          $(this).attr('disabled',true);
          $.ajax({
            type:'GET',
            url:"../api/nutrientesPorAlimento/"+alimentoId,
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
                    type:'PUT',
                    url:"alimentosporcomida/"+comidaPorAlimentoId,
                    dataType:"json",
                    data:{
                      comidaId : $('#comidaId'+comidaPorAlimentoId).val(),
                      alimentoId : $('#alimentosPorComida'+comidaPorAlimentoId).val(),
                      cantidadNeto: $('#cantidadNeto'+comidaPorAlimentoId).val(),
                      selectUnidadMedida : $('#selectUnidadMedida'+comidaPorAlimentoId).val(),
                    },
                    //aca me quede
                    success: function(response){
                        $('#modalEditarAlimentoPorComida'+comidaPorAlimentoId).modal('hide');
                        $('#divMensaje').addClass('alert-success');
                        $('#divMensaje').text("Registro editado");
                        $('#divMensaje').fadeOut(4000);
                        $('#cantidadNeto').val("");
                        $('#selectUnidadMedida').val("");
                        var table = $('#tableAlimentosPorComida').DataTable();
                        table.draw();
                        },
                    error:function(){
                      $("#labelComprobar"+comidaPorAlimentoId).text("ERROR 2");
                    }
                  });
                }
                else{
                  $(this).attr('disabled',false);
                  $("#labelComprobar"+comidaPorAlimentoId).text("El alimento seleccionado no tiene los nutrientes cargados");
                }
            },
            error:function(){
              $("#labelComprobar"+comidaPorAlimentoId).text("ERROR 1");
              devolver = false;
            }
          });
        }else{
          if(verificacionCantidadNeto == false){
            $("#labelComprobar"+comidaPorAlimentoId).text("La cantidad debe ser un número positivo");
          }
          else{
            $("#labelComprobar"+comidaPorAlimentoId).text("Verifique los campos");
          }
        }
      });
  
    $(".btnEditar").click(function(){
      $('#labelNombre').removeClass('text-danger');
      $('.btnEditar').attr('disabled',false);
    });   



    $('#option1').hide();
    $('#option2').hide();
    $('#option3').hide();
    $('.js-example-basic-single').select2();
    $('#alimentosPorComida').select2({
      width: 'resolve',
      theme: "classic",
      placeholder: "Alimentos",
      allowClear: true
    });
  });


// click en el boton editar y mostrar los datos de la fila preseleccionados.
function editarAlimentoPorComidaInicio(unidadesMedida,alimentoPorComidaId,unidadMedidaId) {
    
    for (var unidad in unidadesMedida) {
        if(unidadMedidaId == unidadesMedida[unidad].UnidadMedidaId){
            var unidadMedida = unidadesMedida[unidad].UnidadMedidaNombre;
            
            if(unidadMedida == 'Litro' || unidadMedida == 'Mililitro' || unidadMedida == 'Kilolitro'){
                    var esVisibleOption2 = $("#option2"+alimentoPorComidaId).is(":visible");
                    var esVisibleOption3 = $("#option3"+alimentoPorComidaId).is(":visible");
                    if(!esVisibleOption2 && !esVisibleOption3){
                            $('#option1'+alimentoPorComidaId).show();
                            $('#option2'+alimentoPorComidaId).show();
                            $('#option3'+alimentoPorComidaId).show();
                    }
                    $('#option1'+alimentoPorComidaId).val("Litro");
                    $('#option2'+alimentoPorComidaId).val("Mililitro");
                    $('#option3'+alimentoPorComidaId).val("Kilolitro");
                    $('#option1'+alimentoPorComidaId).text("Litro");
                    $('#option2'+alimentoPorComidaId).text("Mililitro");
                    $('#option3'+alimentoPorComidaId).text("Kilolitro");
                    if(unidadMedida == 'Litro'){
                            
                            $('#option1'+alimentoPorComidaId).attr("selected",true);
                            $('#option2'+alimentoPorComidaId).attr("selected",false);
                            $('#option3'+alimentoPorComidaId).attr("selected",false);
                    }
                    if(unidadMedida == 'Mililitro'){
                            
                            $('#option2'+alimentoPorComidaId).attr("selected",true);
                            $('#option1'+alimentoPorComidaId).attr("selected",false);
                            $('#option3'+alimentoPorComidaId).attr("selected",false);
                    }
                    if(unidadMedida == 'Kilolitro'){
                            $('#option3'+alimentoPorComidaId).attr("selected",true);
                            $('#option2'+alimentoPorComidaId).attr("selected",false);
                            $('#option1'+alimentoPorComidaId).attr("selected",false);
                    }
            }
            if(unidadMedida == 'Gramo' || unidadMedida == 'Kilogramo' || unidadMedida == 'Miligramo'){
                    var esVisibleOption2 = $("#option2"+AlimentoPorComidaId).is(":visible");
                    var esVisibleOption3 = $("#option3"+AlimentoPorComidaId).is(":visible");
                    if(!esVisibleOption2 && !esVisibleOption3){
                            $('#option1'+alimentoPorComidaId).show();
                            $('#option2'+alimentoPorComidaId).show();
                            $('#option3'+alimentoPorComidaId).show();
                    }
                    $('#option1'+alimentoPorComidaId).val("Gramo");
                    $('#option2'+alimentoPorComidaId).val("Kilogramo");
                    $('#option3'+alimentoPorComidaId).val("Miligramo");
                    $('#option1'+alimentoPorComidaId).text("Gramo");
                    $('#option2'+alimentoPorComidaId).text("Kilogramo");
                    $('#option3'+alimentoPorComidaId).text("Miligramo");
                    if(unidadMedida == 'Gramo'){
                            $('#option1'+alimentoPorComidaId).attr("selected",true);
                            $('#option2'+alimentoPorComidaId).attr("selected",false);
                            $('#option3'+alimentoPorComidaId).attr("selected",false);
                    }
                    if(unidadMedida == 'Kilogramo'){
                            
                            $('#option2'+alimentoPorComidaId).attr("selected",true);
                            $('#option1'+alimentoPorComidaId).attr("selected",false);
                            $('#option3'+alimentoPorComidaId).attr("selected",false);
                    }
                    if(unidadMedida == 'Miligramo'){
                            $('#option3'+alimentoPorComidaId).attr("selected",true);
                            $('#option2'+alimentoPorComidaId).attr("selected",false);
                            $('#option1'+alimentoPorComidaId).attr("selected",false);
                    }
            }
            
            if(unidadMedida == "Unidad"){
                    $('#option1'+alimentoPorComidaId).val("Unidad");
                    $('#option1'+alimentoPorComidaId).text("Unidad");
                    $('#option1'+alimentoPorComidaId).show();
                    $('#option2'+alimentoPorComidaId).hide();
                    $('#option3'+alimentoPorComidaId).hide();
                    $('#option1'+alimentoPorComidaId).attr("selected",true);
                    $('#option2'+alimentoPorComidaId).attr("selected",false);
                    $('#option3'+alimentoPorComidaId).attr("selected",false);
            }
            //$('.unidadMedida').text(unidadesMedida[unidad].UnidadMedidaNombre);

        }
    }
}
// cambiar alimento y ofrecer las unidades de medida correspondientes
function editarAlimentoPorComidaUnidadMedida(unidadesMedida,alimentos,alimentoPorComidaId){
    var alimentoId = $('select[name="alimentoId'+alimentoPorComidaId+'"] option:selected').val();
    for (var item in alimentos) {
        if (alimentos[ item ].AlimentoId == alimentoId) {
             var unidadMedidaId = alimentos[item].UnidadMedidaId; 
                
        }
    }
    for (var unidad in unidadesMedida) {
        if(unidadMedidaId == unidadesMedida[unidad].UnidadMedidaId){
            var unidadMedida = unidadesMedida[unidad].UnidadMedidaNombre;
            if(unidadMedida == 'Litro' || unidadMedida == 'Mililitro' || unidadMedida == 'Kilolitro'){
                    var esVisibleOption2 = $('#option2'+alimentoPorComidaId).is(":visible");
                    var esVisibleOption3 = $('#option3'+alimentoPorComidaId).is(":visible");
                    if(!esVisibleOption2 && !esVisibleOption3){
                            $('#option1'+alimentoPorComidaId).show();
                            $('#option2'+alimentoPorComidaId).show();
                            $('#option3'+alimentoPorComidaId).show();
                    }
                    $('#option1'+alimentoPorComidaId).val("Litro");
                    $('#option2'+alimentoPorComidaId).val("Mililitro");
                    $('#option3'+alimentoPorComidaId).val("Kilolitro");
                    $('#option1'+alimentoPorComidaId).text("Litro");
                    $('#option2'+alimentoPorComidaId).text("Mililitro");
                    $('#option3'+alimentoPorComidaId).text("Kilolitro");
            }
            if(unidadMedida == 'Gramo' || unidadMedida == 'Kilogramo' || unidadMedida == 'Miligramo'){
                    var esVisibleOption2 = $('#option2'+alimentoPorComidaId).is(":visible");
                    var esVisibleOption3 = $('#option3'+alimentoPorComidaId).is(":visible");
                    if(!esVisibleOption2 && !esVisibleOption3){
                            $('#option1'+alimentoPorComidaId).show();
                            $('#option2'+alimentoPorComidaId).show();
                            $('#option3'+alimentoPorComidaId).show();
                    }
                    $('#option1'+alimentoPorComidaId).val("Gramo");
                    $('#option2'+alimentoPorComidaId).val("Kilogramo");
                    $('#option3'+alimentoPorComidaId).val("Miligramo");
                    $('#option1'+alimentoPorComidaId).text("Gramo");
                    $('#option2'+alimentoPorComidaId).text("Kilogramo");
                    $('#option3'+alimentoPorComidaId).text("Miligramo");
            }
            if(unidadMedida == "Unidad"){
                    $('#option1'+alimentoPorComidaId).val("Unidad");
                    $('#option1'+alimentoPorComidaId).text("Unidad");
                    $('#option1'+alimentoPorComidaId).show();
                    $('#option2'+alimentoPorComidaId).hide();
                    $('#option3'+alimentoPorComidaId).hide();
            }
            //$('.unidadMedida').text(unidadesMedida[unidad].UnidadMedidaNombre);

        }
    }
}

// $(document).ready(function() {
//         // $('#option1'+alimentoPorComidaId).hide();
//         // $('#option2'+alimentoPorComidaId).hide();
//         // $('#option3'+alimentoPorComidaId).hide();
//         //     $('.js-example-basic-single').select2();
//         //     $('#alimentosPorComida'+alimentoPorComidaId).select2({
//         //         placeholder:'Alimento',
//         //         allowClear:true                 }
//         //     );
// });