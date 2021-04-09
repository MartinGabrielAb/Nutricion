$(document).ready( function () {
  /*--------------Obtener la tabla y cargarla -----------*/
    var menuId = $('#menuId').val();
      $.ajax({
          type:'GET',
          url:"../api/getNutrientes",
          data:{
            id: menuId,
          },
          dataType:"json",
          beforeSend: function(response){

          },
         success: function(response) {
              var acumulador = [];
            for (let comida = 0; comida < response.length; comida++){
              var cantAlimentos = response[comida].alimentos.length;
              var trComida = `<tr>
                                <td rowspan='${cantAlimentos+1}' class="text-center align-middle">
                                  <p class="text-xs"><small>${response[comida].nombreComida}</small></p>
                                </td>
                              </tr> `;
              $('#bodyNutrientes').append(trComida);

              for (let alimento = 0; alimento < response[comida].alimentos.length; alimento++){

                var trAlimento = `<tr id='${alimento}'>
                                    <td class="text-center align-middle">
                                      <p class="text-xs"><small>${response[comida].alimentos[alimento].nombreAlimento}</small></p>
                                    </td>
                                    <td class="text-center align-middle">
                                      <p class="text-xs"><small>${response[comida].alimentos[alimento].cantidadAlimento}</small></p>
                                    </td>
                                  </tr>`;
              $('#bodyNutrientes').append(trAlimento);
                for (let nutriente = 0; nutriente < response[comida].alimentos[alimento].nutrientes.length; nutriente++){
                var tdNutriente = `<td class="text-center align-middle">
                                      <p class="text-xs">
                                      <small>${response[comida].alimentos[alimento].nutrientes[nutriente]}</small>
                                      </p>
                                    </td>`;
                $('#'+alimento).append(tdNutriente);
                if (isNaN(acumulador[nutriente])) {
                  
                  acumulador[nutriente] = 0;
                }
                acumulador[nutriente] = acumulador[nutriente] + response[comida].alimentos[alimento].nutrientes[nutriente];
              }
            }
          }
            var trTotales = `<tr id='totales'>
                              <td class="text-center align-middle">
                                      <p class="text-xs">
                                      <small>Totales</small>
                                      </p>
                                    </td>
                              <td class="text-center align-middle">
                                      <p class="text-xs">
                                      <small></small>
                                      </p>
                              </td>
                              <td class="text-center align-middle">
                                      <p class="text-xs">
                                      <small></small>
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
          error:function(){
          }
      });
  });