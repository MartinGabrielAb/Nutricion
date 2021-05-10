$(document).ready( function () {
  table = $('#tableRelevamientos').DataTable({
    responsive: true,
    "serverSide":true,
    "ajax": "/relevamientos",
    rowId: "RelevamientoId",
    "columns": [
      {data: "RelevamientoId", name:"r.RelevamientoId"},
      {data: "SalaNombre", name:"s.SalaNombre"},
      {data: "RelevamientoFecha", name:"r.RelevamientoFecha"},
      {data: "RelevamientoTurno", name:"r.RelevamientoTurno"},
      {data:'btn',orderable:false,sercheable:false},
    ],
    "language": { "url": "../JSON/Spanish_dataTables.json"},
    "order": [[ 0, "desc" ]],
  });

  $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
  
  /*------Funcion para llenar los campos cuando selecciono una fila -----*/ 
  $('#tableRelevamientos tbody').on( 'click', 'button', function () {
    $("#tituloModal").text("Editar relevamiento");
    $("#btnGuardar span").text("Editar");
    vaciarCampos();
    var data = table.row( $(this).parents('tr') ).data();
    $("#id").val(data['RelevamientoId']);
    $("#salaId").val(data['SalaId']).trigger('change');
    fecha = data['RelevamientoFecha']; //dd/mm/YYYY
    fechaseparada = fecha.split("/");
    fecha = fechaseparada[2] + '-' + fechaseparada[1] + '-' + fechaseparada[0]; //YYYY/mm/dd
    $("#fecha").val(fecha);
    $('#turno').val(data['RelevamientoTurno']).trigger('change');
  });

  //select2
  $('#turno').select2({
    width: 'resolve',
    theme: "classic",
    placeholder: {
          id: '-1', 
          text: "Turno",
        },
    allowClear: true
  });
  $('#salaId').select2({
    width: 'resolve',
    theme: "classic",
    placeholder: {
          id: '-1', 
          text: "Sala",
        },
    allowClear: true
  });
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
        salaId: $('#salaId').val(),
        fecha: $('#fecha').val(),
        turno: $('#turno').val(),
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
      salaId: $('#salaId').val(),
      fecha: $('#fecha').val(),
      turno: $('#turno').val(),
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
  $("#salaId").val(-1).trigger('change');
  $("#fecha").val("");
  $("#turno").val(-1).trigger('change');
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
