   
function llenarNutrientes(id){
    $('#bodyNutrientes').empty();
    $.ajax({
        type:'GET',
        url:"../alimentosporcomida/"+id,
        dataType:"json",
        success: function(response){
            var acumulador = [];
            for (let alimento = 0; alimento < response.length; alimento++){
                var trAlimento = `<tr id=tr${alimento}>
                                    <td class="text-center align-middle">
                                      <p class="text-xs"><small>${response[alimento].nombreAlimento}</small></p>
                                    </td>
                                    <td class="text-center align-middle">
                                      <p class="text-xs"><small>${response[alimento].cantidadAlimento} </small></p>
                                    </td>
                                  </tr>`;
                $('#bodyNutrientes').append(trAlimento);
                var nutrientes = response[alimento].nutrientes;
                for (let nutriente = 0; nutriente < nutrientes.length; nutriente++){
                  var tdNutriente = `<td class="text-center align-middle">
                                      <p class="text-xs">
                                      <small>${nutrientes[nutriente]}</small>
                                      </p>
                                      </td>`;
                  $('#tr'+alimento).append(tdNutriente);
                  if (isNaN(acumulador[nutriente])) { 
                      acumulador[nutriente] = 0;
                  }
                    acumulador[nutriente] = acumulador[nutriente] + nutrientes[nutriente];
                }
            }
            var trTotales = 
                `<tr id='totales'>
                    <td class="text-center align-middle">
                            <p class="text-xs">
                            <small>Totales</small>
                            </p>
                    </td>
                    <td class="text-center align-middle">
                            <p class="text-xs">
                            <small> - </small>
                            </p>
                    </td>
                </tr>`
            $('#bodyNutrientes').append(trTotales); 
            for (let index= 0; index < acumulador.length; index++) {
                var tdTotales = `<td class="text-center align-middle">
                                          <p class="text-xs">
                                          <small>${acumulador[index]}</small>
                                          </p>
                                  </td>`;
                $('#totales').append(tdTotales);
            }             
        },
        error:function(response){
  
        }
      });
}