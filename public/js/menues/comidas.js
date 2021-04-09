
$(document).ready( function () {
  /*--------------Obtener la tabla y cargarla -----------*/
    var menuId = $('#menuId').val();
    $('#tableComidas').DataTable({
          "serverSide":true,
          "ajax":{
            "url":"../api/comidasPorTipoPaciente",
            data:{
              'id' : menuId,
            },
            },
            rowId: 'ComidaPorTipoPacienteId',
          "columns": [
            {data: 'ComidaPorTipoPacienteId'},
            {data: 'TipoComida'},
            {data: 'ComidaId'},
            {data: 'ComidaPorTipoPacienteCostoTotal'},
            {data:'btn',orderable:false,sercheable:false},
          ],
          "language": {
          "url": "../JSON/Spanish_dataTables.json",
          },
          responsive: true
      });

/*--------------Guardar el menu nuevo-----------*/

$("#btnGuardarTipo").click(function(){
      $('#divMensaje').removeClass('alert-success alert-danger');
      $('#divMensaje').fadeIn();
      $('#divMensaje').text("");
      $('#labelComprobarTipo').removeClass('alert-success alert-danger');
      $('#labelComprobarTipo').fadeIn();
      $('#labelComprobarTipo').text("");
      $('#btnGuardarTipo').attr('disabled',true);
      $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
      });
      $.ajax({
        type:'GET',
        url:"../getComidaPorTipoPaciente",
        data:{
          'id': $('#menuId').val(),
        },
        dataType:"json",
        beforeSend: function(response){
          $("#labelComprobarTipo").text("Verificando datos...");
        },
       success: function(response) {
          $("#labelComprobarTipo").text("");
          var tipoComida = $('#tipoComida option:selected').val();
          var devolver = true;
          for (let index = 0; index < response.tiposComida.length; index++){
            if(response.tiposComida[index]['TipoComidaId'] == tipoComida){
              devolver = false;
              $("#labelTipo").text("El tipo de comida ya fue agregado");
              $("#labelTipo").addClass('text-danger');
              break;
            }
          }
          $('#btnGuardarTipo').attr('disabled',false);
          if(devolver == true){
              $.ajax({
                type:'POST',
                url:"../comidaportipopaciente",
                dataType:"json",
                data:{
                  tipoComida: $('#tipoComida option:selected').val(),
                  menuId: $('#menuId').val(),
                },
                success: function(response){
                  $('#modalAgregar').modal('hide');
                  $('#divMensaje').addClass('alert-success');
                  $('#divMensaje').text("Registro agregado correctamente.");
                  $('#divMensaje').fadeOut(4000);
                  actualizarTablaNutrientes();
                  var table = $('#tableComidas').DataTable();
                  table.draw();
                  
                  },
                error:function(){
                  $("#labelComprobarTipo").text("Error Post");
                }
              });
            }
        },
        error:function(){
          $("#labelComprobarTipo").text("Error");
          devolver = false;
        }
      });
    });
  
  
  $("select#tipoComida").change(function(){
    $('#labelTipo').removeClass('text-danger');
    $('#labelTipo').text('Seleccione el tipo de menu');
    $('#btnGuardarTipo').attr('disabled',false);
  });
  $("#btnAgregar").click(function(){
    $('#labelTipo').removeClass('text-danger');
    $('#labelTipo').text('Seleccione el tipo de menu');
    $('#btnGuardarTipo').attr('disabled',false);
  });

});

/*-------------Eliminar menu -----------*/
function eliminarTipoComida(id){
      $('#modalEliminar'+id).modal('hide');
      $('#divMensaje').removeClass('alert-success alert-danger');
      $('#divMensaje').fadeIn();
      $('#divMensaje').text("");
      $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
      });
      $.ajax({
        type:"DELETE",
        url: "../comidaportipopaciente/"+id,
        data: {
          "_method": 'DELETE',
          "id": id
        },
        beforeSend: function(response){

        },
       success: function(response) {
          $('#divMensaje').addClass('alert-success');
          $('#divMensaje').text("Registro eliminado correctamente.");
          $('#divMensaje').fadeOut(4000);
          var table = $('#tableComidas').DataTable();
          table.row('#'+id).remove().draw();
          actualizarTablaNutrientes();
          table.draw();

        },
        error:function(){
          $('#divMensaje').addClass('alert-danger');
          $('#divMensaje').text("Error al eliminar el registro.");
          $('#divMensaje').fadeOut(4000);
        }
      });
}

/*--------------------Editar Comida-------------------*/
function editarComida(id){
      $('#divMensaje').removeClass('alert-success alert-danger');
      $('#divMensaje').fadeIn();
      $('#divMensaje').text("");
      $('#labelComprobar'+id).removeClass('alert-success alert-danger');
      $('#labelComprobar'+id).fadeIn();
      $('#labelComprobar'+id).text("");
      $('#btnGuardar'+id).attr('disabled',true);
      $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
      });
      $.ajax({
      type:'PUT',
      url:"../comidaportipopaciente/"+id,
      dataType:"json",
      data:{
            id : id,
            comidaId: $('#comida'+id +' option:selected').val(),
      },
        success: function(response){
            $('#labelComprobar'+id).addClass('alert-success');
            $('#labelComprobar'+id).text("Comida asignada con exito.");
            $('#labelComprobar'+id).fadeOut(4000);
            actualizarTablaNutrientes();
            var table = $('#tableComidas').DataTable();
            table.draw();
            $('#modalEditar'+id).modal('hide');
            $('#divMensaje').addClass('alert-success');
            $('#divMensaje').text("Comida asignada con exito.");
            $('#divMensaje').fadeOut(4000);
            
            },
        error:function(){
            $("#labelComprobar"+id).text("ERROR 2");
            },
      });
    }

function actualizarTablaNutrientes(){
  $('#bodyNutrientes').empty();
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
}

