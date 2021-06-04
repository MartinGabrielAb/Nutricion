function llenarComidas(id){
  $("#divChecks").empty();
    $.ajax({
        type:'GET',
        url:"../comidaportipopaciente/"+id,
        dataType:"json",
        beforeSend:function(){
        },
        success: function(response){
            if(response.lenght==0){
                mostrarCartel('Debe cargar comidas para simular.','alert-danger');
                return;
            }
            for (var campo in response) {
                $("#divChecks").append("<div class='form-check'>"+
                    "<input id='"+response[campo]['ComidaId']+"' type='checkbox' class='form-check-input' ></input>"
                    +"<label class='form-check-label' for='"+response[campo]['ComidaId']+"'>"+response[campo]['ComidaNombre']+"</label></div>"
                    );
              } 
        },
        error:function(response){
          var errors =  response.responseJSON.errors;
          for (var campo in errors) {
            $("#listaErrores2").append('<li type="square">'+errors[campo]+'</li>');
          }       
        }
      });
}

function simular(e){
    $('#bodyNutrientes').empty();
    $('#modalElegir').modal('hide');
    e.preventDefault();
    var id = $("#detalleMenuTipoPacienteId").val();
    let seleccionados = [];
    //Obtengo las comidas seleccionadas 
    $('input[type=checkbox]:checked').each(function() {
        seleccionados.push(parseInt($(this).prop("id")));
    });
    // Ahora busco los nutrientes
    $.ajax({
        type:'GET',
        url:"../comidaportipopaciente/"+id+"/edit",
        dataType:"json",
        data:{
          comidas : seleccionados,
        },
        beforeSend:function(){
        },
        success: function(response){
           for (let comida of response.comidas){
            var trComida = `<tr id=trComida${comida.comidaId}>
              <td class="text-center align-middle" rowspan=${comida.alimentos.length}>
                <p class="text-xs"><small>${comida.tipoComida}</small></p>
              </td>
              <td class="text-center align-middle rowspan="${comida.alimentos.length}">
                <p class="text-xs"><small>${comida.comida} </small></p>
              </td>
            </tr>`;
            $('#bodyNutrientes').append(trComida);
            var alimentos = comida.alimentos;
            for (let alimento of alimentos){
              var tdAlimento = `<td class="text-center align-middle">
                                  <p class="text-xs">
                                  <small>${alimento.alimento}</small>
                                  </p>
                                  </td>
                                  <td class="text-center align-middle">
                                  <p class="text-xs">
                                  <small>${alimento.cantidad}</small>
                                  </p>
                                  </td>`;
              $('#bodyNutrientes').append(tdAlimento);
              var nutrientes = alimento.nutrientes;
              for (let nutriente of nutrientes){
                var tdNutriente = `<td class="text-center align-middle">
                                    <p class="text-xs">
                                    <small>${nutriente}</small>
                                    </p>
                                    </td>`;
                $('#trComida'+alimento.alimentoId).append(tdNutriente);
              }
            }
          }
        },
        error:function(response){
          var errors =  response.responseJSON.errors;
          for (var campo in errors) {
            $("#listaErrores2").append('<li type="square">'+errors[campo]+'</li>');
          }       
        }
      });
}