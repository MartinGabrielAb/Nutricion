$(document).ready( function () {
  var table = $('#tableSalas').DataTable({
    responsive: true,
    "serverSide":true,
    "ajax": "/salas",
      rowId: "SalaId",
    "columns": [
      {data: "SalaId"},
      {data: "SalaNombre"},
      {data:'btn',orderable:false,sercheable:false},
    ],
    "language": { "url": "../JSON/Spanish_dataTables.json"},
  });

  $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
  
  /*------Funcion para llenar los campos cuando selecciono una fila -----*/ 
  $('#tableSalas tbody').on( 'click', 'button', function () {
    $("#tituloModal").text("Editar sala");
    $("#btnGuardar span").text("Editar");
    vaciarCampos();
    var data = table.row( $(this).parents('tr') ).data();
    $("#id").val(data['SalaId']);
    $("#nombre").val(data['SalaNombre']);
  });
});

function vaciarCampos(){
  $("#nombre").val("");
  $("#listaErrores").empty();
}

function agregar(){
  $("#id").val(0);
  vaciarCampos();
  $("#tituloModal").text("Agregar sala");
  $("#btnGuardar span").text("Guardar");
}


function guardar(e){
  $("#listaErrores").empty();
  e.preventDefault();
  var id = $("#id").val();
  if(id == 0){
    $.ajax({
      type:'POST',
      url:"salas",
      dataType:"json",
      data:{
        salaNombre: $('#nombre').val(),
      },
      success: function(response){
        $('#modal').modal('hide');
        mostrarCartel('Registro agregado correctamente.','alert-success');
        var table = $('#tableSalas').DataTable();
        table.draw();
        },
      error:function(response){
        var errors =  response.responseJSON.errors;
        for (var campo in errors) {
          console.log(errors[campo]);

          $("#listaErrores").append('<li type="square">'+errors[campo]+'</li>');
        }       
      }
    });
  }else{
    editar(id);
  }
}
function editar(id){
  $("#listaErrores").empty();
  $.ajax({
    type:'PUT',
    url:"salas/"+id,
    dataType:"json",
    data:{
      salaNombre: $('#nombre').val(),
    },
    success: function(response){
      $('#modal').modal('hide');
      mostrarCartel('Registro editado correctamente.','alert-success');
      var table = $('#tableSalas').DataTable();
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
function eliminar(id){
  $.ajax({
    type:"DELETE",
    url: "salas/"+id,
    data: {
      "_method": 'DELETE',
      "id": id
    },
    success: function(response) {
      mostrarCartel('Registro eliminado correctamente.','alert-success');
      var table = $('#tableSalas').DataTable();
      table.row('#'+id).remove().draw();
    },
    error:function(){
      mostrarCartel('Error al eliminar el registro.','alert-danger');
    }
  });
}
function mostrarCartel(texto,clase){
    $('#divMensaje').removeClass('alert-success alert-danger');
    $('#divMensaje').fadeIn();
    $('#divMensaje').text(texto);
    $('#divMensaje').addClass(clase);  
    $('#divMensaje').fadeOut(4000);
}



