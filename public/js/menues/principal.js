$(document).ready( function () {
    $('#tableMenues').DataTable({
          "serverSide":true,
          "ajax": '../api/menues',
            rowId: 'MenuId',
          "columns": [
            {data: 'MenuId'},
            {data: 'MenuNombre'},
            {data: 'MenuCostoTotal'},
            {data:'btn',orderable:false,sercheable:false},
          ],
          "language": {
          "url": '../JSON/Spanish_dataTables.json',
          },
          responsive: true
      });

    $('#tableParticulares').DataTable({
          "serverSide":true,
          "ajax": '../api/particulares',
            rowId: 'MenuId',
          "columns": [
            {data: 'MenuId'},
            {data: 'MenuNombre'},
            {data: 'MenuCostoTotal'},
            {data:'btn',orderable:false,sercheable:false},
          ],
          "language": {
          "url": '../JSON/Spanish_dataTables.json',
          },
          responsive: true
      });
});

 /*--------------Editar Menu------------------*/
function editarMenu(id){
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
        url:"getMenues",
        dataType:"json",
        beforeSend: function(response){
          $("#labelComprobar"+id).text("Verificando datos...");
        },
       success: function(response) {
          $("#labelComprobar"+id).text("");
          var nombre = $('#menuNombre'+id).val();
          var devolver = true;
          for (let index = 0; index < response.menues.length; index++){
            var menuNombre = response.menues[index]['MenuNombre'];
            var menuId = response.menues[index]['MenuId'];
            if(menuNombre == nombre && menuId != id){
              devolver = false;
              $("#labelNombre"+id).text("El menú ingresada ya existe");
              $("#labelNombre"+id).addClass('text-danger');
              break;
            }
          }
          if(devolver == true){
              $.ajax({
                type:'PUT',
                url:"menu/"+id,
                dataType:"json",
                data:{
                  menuNombre: $('#menuNombre'+id).val(),
                },
                success: function(response){
                  $('#labelComprobar'+id).addClass('alert-success');
                  $('#labelComprobar'+id).text("Registro editado.");
                  $('#labelComprobar'+id).fadeOut(4000);
                  $('#menuNombre'+id).val("");
                  var table = $('#tableMenues').DataTable();
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

    $("#menuNombre"+id).click(function(){
    $('#labelNombre'+id).removeClass('text-danger');
    $('#labelNombre'+id).text('Nombre');
    $('#btnGuardar'+id).attr('disabled',false);
  }); 
}

 /*--------------Eliminar Menu------------------*/

function eliminarMenu(id){
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
        url: "menu/"+id,
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
          var table = $('#tableMenues').DataTable();
          table.row('#'+id).remove().draw();
          var table = $('#tableParticulares').DataTable();
          table.row('#'+id).remove().draw();
        },
        error:function(){
          $('#divMensaje').addClass('alert-danger');
          $('#divMensaje').text("Error al eliminar el registro.");
          $('#divMensaje').fadeOut(4000);
        }
      });
}
