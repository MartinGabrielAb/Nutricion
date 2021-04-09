$(document).ready( function () {
    $('#tableSalas').DataTable({
          "serverSide":true,
          "ajax": '../api/salas',
            rowId: 'SalaId',
          "columns": [
            {data: 'SalaId'},
            {data: 'SalaNombre'},
            {data:'btn',orderable:false,sercheable:false},
          ],
          "language": {
          "url": '../JSON/Spanish_dataTables.json',
          },
          responsive: true
      });

    });

function eliminarSala(id){
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
        url: "salas/"+id,
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
          var table = $('#tableSalas').DataTable();
          table.row('#'+id).remove().draw();
        },
        error:function(){
          $('#divMensaje').addClass('alert-danger');
          $('#divMensaje').text("Error al eliminar el registro.");
          $('#divMensaje').fadeOut(4000);
        }
      });
}
function editarSala(id){
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
        type:'GET',
        url:"getSalas",
        dataType:"json",
        beforeSend: function(response){
          $("#labelComprobar"+id).text("Verificando datos...");
        },
       success: function(response) {
          $("#labelComprobar"+id).text("");
          var nombre = $('#salaNombre'+id).val();
          var devolver = true;
          for (let index = 0; index < response.salas.length; index++){
            var salaNombre = response.salas[index]['SalaNombre'];
            var salaId = response.salas[index]['SalaId'];
            if(salaNombre == nombre && salaId != id){
              devolver = false;
              $("#labelNombre"+id).text("La sala ingresada ya existe");
              $("#labelNombre"+id).addClass('text-danger');
              break;
            }
          }
          if(devolver == true){
              $.ajax({
                type:'PUT',
                url:"salas/"+id,
                dataType:"json",
                data:{
                  salaNombre: $('#salaNombre'+id).val(),
                },
                success: function(response){
                  $('#labelComprobar'+id).addClass('alert-success');
                  $('#labelComprobar'+id).text("Registro editado.");
                  $('#labelComprobar'+id).fadeOut(4000);
                  $('#salaNombre'+id).val("");
                  var table = $('#tableSalas').DataTable();
                  table.draw();
                  $('#modalEditar'+id).modal('hide');
                  $('#divMensaje').addClass('alert-success');
                  $('#divMensaje').text("Registro editado correctamente.");
                  $('#divMensaje').fadeOut(4000);
                  },
                error:function(){
                  $("#labelComprobar"+id).text("ERROR 2");
                },
              });
            }
        },
        error:function(){
          $("#labelComprobar"+id).text("ERROR 1");
          devolver = false;
        },
      });

    $("#salaNombre"+id).click(function(){
    $('#labelNombre'+id).removeClass('text-danger');
    $('#labelNombre'+id).text('Nombre');
    $('#btnGuardar'+id).attr('disabled',false);
  }); 
}