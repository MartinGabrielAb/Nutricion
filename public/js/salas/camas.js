$(document).ready( function () {

  /*--------------Obtener la tabla y cargarla -----------*/
    var piezaId = $('#piezaId').val();
    $('#tableCamas').DataTable({
          "serverSide":true,
          "ajax":{
            "url":"../api/camas",
            data:{
              'id' : piezaId,
            },
            },
            rowId: 'CamaId',
          "columns": [
            {data: 'CamaNumero'},
            {data: 'CamaEstado'},
            {data:'btn',orderable:false,sercheable:false},
          ],
          "language": {
          "url": "../JSON/Spanish_dataTables.json",
          },
          responsive: true
      });
/*--------------Crear un Cama -----------*/

    $('#btnGuardar').click(function(){

      $('#divMensaje').removeClass('alert-success alert-danger');
      $('#divMensaje').fadeIn();
      $('#divMensaje').text("");
      $('#labelComprobar').removeClass('alert-success alert-danger');
      $('#labelComprobar').fadeIn();
      $('#labelComprobar').text("");
      $('#btnGuardar').attr('disabled',true);
      $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
      });
      
              $.ajax({
                type:'POST',
                url:"../camas",
                dataType:"json",
                data:{
                  piezaId: $('#piezaId').val(),
                },
                success: function(response){
                  $('#modalAgregar').modal('hide');
                  $('#divMensaje').addClass('alert-success');
                  $('#divMensaje').text("Registro agregado correctamente.");
                  $('#divMensaje').fadeOut(4000);
                  var table = $('#tableCamas').DataTable();
                  table.draw();
                  },
                error:function(){
                  $("#labelComprobar").text("ERROR");
                }
              });
    });

  $("#btnAgregar").click(function(){
    $('#btnGuardar').attr('disabled',false);
  });
  
  });
/*--------------------Eliminar una Cama----------------*/
function eliminarCama(id){
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
        url: "../camas/"+id,
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
          var table = $('#tableCamas').DataTable();
          table.row('#'+id).remove().draw();
        },
        error:function(){
          $('#divMensaje').addClass('alert-danger');
          $('#divMensaje').text("Error al eliminar el registro.");
          $('#divMensaje').fadeOut(4000);
        }
      });
}

