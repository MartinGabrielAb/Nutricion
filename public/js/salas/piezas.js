$(document).ready( function () {

  /*--------------Obtener la tabla y cargarla -----------*/
    var salaId = $('#salaId').val();
    $('#tablePiezas').DataTable({
          "serverSide":true,
          "ajax":{
            "url":"../api/piezas",
            data:{
              'id' : salaId,
            },
            },
            rowId: 'PiezaId',
          "columns": [
            {data: 'PiezaId'},
            {data: 'PiezaNombre'},
            {data: 'Camas'},
            {data:'btn',orderable:false,sercheable:false},
          ],
          "language": {
          "url": "../JSON/Spanish_dataTables.json",
          },
          responsive: true
      });
/*--------------Crear un pieza -----------*/

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
        type:'GET',
        url:"../getPiezas",
        data:{
          'id': $('#salaId').val(),
        },
        dataType:"json",
        beforeSend: function(response){
          $("#labelComprobar").text("Verificando datos...");
        },
       success: function(response) {
          $("#labelComprobar").text("");
          var nombre = $('input[name="piezaNombre"]').val();
          var devolver = true;
          for (let index = 0; index < response.piezas.length; index++){
            if(response.piezas[index]['PiezaNombre'] == nombre){
              devolver = false;
              $("#labelNombre").text("La pieza ingresada ya existe");
              $("#labelNombre").addClass('text-danger');
              break;
            }
            if(nombre == ''){
              devolver = false;
              $("#labelNombre").text("Este campo no debe estar vacio");
              $("#labelNombre").addClass('text-danger');
              break;
            }
          }
          if(devolver == true){
              $.ajax({
                type:'POST',
                url:"../pieza",
                dataType:"json",
                data:{
                  piezaNombre: $('input[name="piezaNombre"]').val(),
                  salaId: $('#salaId').val(),
                },
                success: function(response){
                  $('#piezaNombre').val("");
                  $('#modalAgregar').modal('hide');
                  $('#divMensaje').addClass('alert-success');
                  $('#divMensaje').text("Registro agregado correctamente.");
                  $('#divMensaje').fadeOut(4000);
                  var table = $('#tablePiezas').DataTable();
                  table.draw();
                  },
                error:function(){
                  $("#labelComprobar").text("ERROR 2");
                }
              });
            }
        },
        error:function(){
          $("#labelComprobar").text("ERROR 1");
          devolver = false;
        }
      });
    });
  $("#piezaNombre").click(function(){
    $('#labelNombre').removeClass('text-danger');
    $('#labelNombre').text('Nombre');
    $('#btnGuardar').attr('disabled',false);
  });

  $("#btnAgregar").click(function(){
    $('#labelNombre').removeClass('text-danger');
    $('#labelNombre').text('Nombre');
    $('#piezaNombre').val("");
    $('#btnGuardar').attr('disabled',false);
  });
  
  });
/*--------------------Eliminar una Pieza----------------*/
function eliminarPieza(id){
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
        url: "../pieza/"+id,
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
          var table = $('#tablePiezas').DataTable();
          table.row('#'+id).remove().draw();
        },
        error:function(){
          $('#divMensaje').addClass('alert-danger');
          $('#divMensaje').text("Error al eliminar el registro.");
          $('#divMensaje').fadeOut(4000);
        }
      });
}



/*--------------------Editar una pieza-------------------*/
function editarPieza(id){
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
        url:"../getPiezas",
        data:{
          'id': $('#salaId').val(),
        },
        dataType:"json",
        beforeSend: function(response){
          $("#labelComprobar"+id).text("Verificando datos...");
        },
       success: function(response) {
          $("#labelComprobar"+id).text("");
          var nombre = $('#piezaNombre'+id).val();
          var devolver = true;
          for (let index = 0; index < response.piezas.length; index++){
            var piezaNombre = response.piezas[index]['PiezaNombre'];
            var piezaId = response.piezas[index]['PiezaId'];
            if(piezaNombre == nombre && piezaId != id){
              devolver = false;
              $("#labelNombre"+id).text("La pieza ingresada ya existe");
              $("#labelNombre"+id).addClass('text-danger');
              break;
            }
            if(nombre == ''){
              devolver = false;
              $("#labelNombre").text("Este campo no debe estar vacio");
              $("#labelNombre").addClass('text-danger');
              break;
            }
          }
          if(devolver == true){
              $.ajax({
                type:'PUT',
                url:"../pieza/"+id,
                dataType:"json",
                data:{
                  piezaNombre: $('#piezaNombre'+id).val(),
                },
                success: function(response){
                  $('#labelComprobar'+id).addClass('alert-success');
                  $('#labelComprobar'+id).text("Registro editado.");
                  $('#labelComprobar'+id).fadeOut(4000);
                  $('#piezaNombre'+id).val("");
                  var table = $('#tablePiezas').DataTable();
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

    $("#piezaNombre"+id).click(function(){
    $('#labelNombre'+id).removeClass('text-danger');
    $('#labelNombre'+id).text('Nombre');
    $('#btnGuardar'+id).attr('disabled',false);
  }); 
}
