$(document).ready( function () {
  table = $('#tableRelevamientos').DataTable({
    responsive: true,
    "serverSide":true,
    "ajax": "/relevamientos",
    rowId: "RelevamientoId",
    "columns": [
      {data: "RelevamientoId"},
      {data: "RelevamientoFecha"},
      {data:'btn',orderable:false,sercheable:false},
    ],
    "language": { "url": "../JSON/Spanish_dataTables.json"},
    "order": [[ 1, "desc" ],[2, "desc"]],
  });

  $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
  
  /*------Funcion para llenar los campos cuando selecciono una fila -----*/ 
  $('#tableRelevamientos tbody').on( 'click', 'button', function () {
    $("#tituloModal").text("Editar relevamiento");
    $("#btnGuardar span").text("Editar");
    vaciarCampos();
    var data = table.row( $(this).parents('tr') ).data();
    $("#id").val(data['RelevamientoId']);
    $("#fecha").val(data['RelevamientoFecha']);
    // $("#turno").val(data['RelevamientoTurno']).trigger('change');
    // $("#menu").val(data['MenuId']).trigger('change');
  });

  //select2
  // $('#turno').select2({
  //   width: 'resolve',
  //   theme: "classic",
  //   placeholder: {
  //     id: '-1', 
  //     text: "Turno",
  //   },
  //   allowClear: true,
  // });
  // $('#menu').select2({
  //   width: 'resolve',
  //   theme: "classic",
  //   placeholder: {
  //     id: '-1', 
  //     text: "Menú",
  //   },
  //   allowClear: true,
  // });
});
//POST AJAX
function guardar(e){
  $("#listaErrores").empty();
  e.preventDefault();
  var id = $("#id").val();
  if(id == 0){
    $.ajax({
      type:'POST',
      url:"relevamientos",
      dataType:"json",
      data:{
        fecha: $('#fecha').val(),
      },
      success: function(response){
        $('#modal').modal('hide');
        mostrarCartel('Registro agregado correctamente.','alert-success');
        var table = $('#tableRelevamientos').DataTable();
        table.draw();
        },
      error:function(response){
        var errors =  response.responseJSON.errors;
        for (var campo in errors) {
          $("#listaErrores").append('<li type="square">'+errors[campo]+'</li>');
        }       
      }
    });
  }else{
    editar(id);
  }
}
//PUT AJAX
function editar(id){
  $("#listaErrores").empty();
  $.ajax({
    type:'PUT',
    url:"relevamientos/"+id,
    dataType:"json",
    data:{
      id: id,
      fecha: $('#fecha').val(),
    },
    success: function(response){
      $('#modal').modal('hide');
      mostrarCartel('Registro editado correctamente.','alert-success');
      var table = $('#tableRelevamientos').DataTable();
      table.draw();
      $('#modalEditar').modal('hide');
      },
      error:function(response){
        var errors =  response.responseJSON.errors;
        for (var campo in errors) {
          console.log(errors[campo]);
          $("#listaErrores").append('<li type="square">'+errors[campo]+'</li>');
        }       
      }
  });
}
//DELETE AJAX
function eliminar(id){
  $.ajax({
    type:"DELETE",
    url: "relevamientos/"+id,
    data: {
      "_method": 'DELETE',
      "id": id
    },
    success: function(response) {
      mostrarCartel('Registro eliminado correctamente.','alert-success');
      var table = $('#tableRelevamientos').DataTable();
      table.row('#'+id).remove().draw();
    },
    error:function(){
      mostrarCartel('Error al eliminar el registro.','alert-danger');
    }
  });
}
//funciones auxiliares
function vaciarCampos(){
  $("#fecha").val("");
  // $("#turno").val(-1).trigger('change');
  // $("#menu").val(-1).trigger('change');
  $("#listaErrores").empty();
}
function agregar(){
  $("#id").val(0);
  vaciarCampos();
  $("#tituloModal").text("Agregar sala");
  $("#btnGuardar span").text("Guardar");
}
function mostrarCartel(texto,clase){
  $('#divMensaje').removeClass('alert-success alert-danger');
  $('#divMensaje').fadeIn();
  $('#divMensaje').text(texto);
  $('#divMensaje').addClass(clase);  
  $('#divMensaje').fadeOut(4000);
}
