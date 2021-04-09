$(document).ready( function () {
  $('.js-example-responsive').select2({
    width: 'resolve',
  });  //Cargar el combobox
  /*--------------Obtener la tabla y cargarla -----------*/
    var menuId = $('#menuId').val();
    $('#tableMenuTipo').DataTable({
          "serverSide":true,
          "ajax":{
            "url":"../api/menuTipo",
            data:{
              'id' : menuId,
            },
            },
            rowId: 'DetalleMenuTipoPacienteId',
          "columns": [
            {data: 'DetalleMenuTipoPacienteId'},
            {data: 'TipoPaciente'},
            {data: 'DetalleMenuTipoPacienteCostoTotal'},
            {data:'btn',orderable:false,sercheable:false},
          ],
          "language": {
          "url": "../JSON/Spanish_dataTables.json",
          },
          responsive: true
      });

/*--------------Guardar el menu nuevo-----------*/

$("#btnGuardarMenu").click(function(){
      $('#divMensaje').removeClass('alert-success alert-danger');
      $('#divMensaje').fadeIn();
      $('#divMensaje').text("");
      $('#labelComprobarMenu').removeClass('alert-success alert-danger');
      $('#labelComprobarMenu').fadeIn();
      $('#labelComprobarMenu').text("");
      $('#btnGuardarMenu').attr('disabled',true);
      $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
      });
      $.ajax({
        type:'GET',
        url:"../getMenuTipo",
        data:{
          'id': $('#menuId').val(),
        },
        dataType:"json",
        beforeSend: function(response){
          $("#labelComprobarMenu").text("Verificando datos...");
        },
       success: function(response) {
          $("#labelComprobarMenu").text("");
          var tipoPaciente = $('#tipoPaciente option:selected').val();
          var devolver = true;
          for (let index = 0; index < response.menues.length; index++){
            if(response.menues[index]['TipoPacienteId'] == tipoPaciente){
              devolver = false;
              $("#labelMenu").text("El tipo de paciente ingresado ya existe");
              $("#labelMenu").addClass('text-danger');
              break;
            }
          }
          $('#btnGuardarMenu').attr('disabled',false);
          if(devolver == true){
              $.ajax({
                type:'POST',
                url:"../menuportipopaciente",
                dataType:"json",
                data:{
                  tipoPaciente: $('#tipoPaciente option:selected').val(),
                  menuId: $('#menuId').val(),
                },
                success: function(response){
                  $('#modalAgregarMenu').modal('hide');
                  $('#divMensaje').addClass('alert-success');
                  $('#divMensaje').text("Registro agregado correctamente.");
                  $('#divMensaje').fadeOut(4000);
                  var table = $('#tableMenuTipo').DataTable();
                  table.draw();
                  },
                error:function(){
                  $("#labelComprobarMenu").text("Error Post");
                }
              });
            }
        },
        error:function(){
          $("#labelComprobarMenu").text("Error");
          devolver = false;
        }
      });
    });
  
  
  $("select#tipoPaciente").change(function(){
    $('#labelMenu').removeClass('text-danger');
    $('#labelMenu').text('Seleccione el tipo de menu');
    $('#btnGuardar').attr('disabled',false);
  });
  $("#btnAgregar").click(function(){
    $('#labelMenu').removeClass('text-danger');
    $('#labelMenu').text('Seleccione el tipo de menu');
    $('#btnGuardar').attr('disabled',false);
  });

});

/*-------------Eliminar menu -----------*/
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
        url: "../menuportipopaciente/"+id,
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
          var table = $('#tableMenuTipo').DataTable();
          table.row('#'+id).remove().draw();
        },
        error:function(){
          $('#divMensaje').addClass('alert-danger');
          $('#divMensaje').text("Error al eliminar el registro.");
          $('#divMensaje').fadeOut(4000);
        }
      });
  }




