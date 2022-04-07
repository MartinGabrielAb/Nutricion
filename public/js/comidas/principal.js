$(document).ready( function () {
  var table = $('#tableComidas').DataTable({
    responsive: true,
    "serverSide":true,
    "ajax": "comidas",
      rowId: "ComidaId",
    "columns": [
      {data: 'ComidaId'},
      {data: 'ComidaNombre'},
      {data: 'TipoComidaNombre'},
      {data: 'btn',orderable:false,sercheable:false},
    ],
    "language": { "url": "public/JSON/Spanish_dataTables.json"},
  });

  $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
  
  /*------Funcion para llenar los campos cuando selecciono una fila -----*/ 
  $('#tableComidas tbody').on( 'click', 'button', function () {
    $("#tituloModal").text("Editar comida");
    $("#btnGuardar span").text("Editar");
    vaciarCampos();
    var data = table.row( $(this).parents('tr') ).data();
    $("#id").val(data['ComidaId']);
    $("#nombre").val(data['ComidaNombre']);
    $("#tipo").val(data['TipoComidaId']).trigger('change');
  });
});

function vaciarCampos(){
  $("#nombre").val("");
  $("#tipo").val("");
}

function agregar(){
  $("#id").val(0);
  vaciarCampos();
  $("#tituloModal").text("Agregar comida");
  $("#btnGuardar span").text("Guardar");
}


function guardar(e){
  $("#listaErrores").empty();
  e.preventDefault();
  var id = $("#id").val();
  if(id == 0){
    $.ajax({
      type:'POST',
      url:"comidas",
      dataType:"json",
      data:{
        nombre: $('#nombre').val(),
        tipo:$('#tipo').val()
      },
      success: function(response){
        $('#modal').modal('hide');
        mostrarCartel('Registro agregado correctamente.','alert-success');
        var table = $('#tableComidas').DataTable();
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
function editar(id){
  $("#listaErrores").empty();
  $.ajax({
    type:'PUT',
    url:"comidas/"+id,
    dataType:"json",
    data:{
      nombre: $('#nombre').val(),
      tipo:$('#tipo').val(),
    },
    success: function(response){
      $('#modal').modal('hide');
      mostrarCartel('Registro editado correctamente.','alert-success');
      var table = $('#tableComidas').DataTable();
      table.draw();
      $('#modalEditar').modal('hide');
      },
      error:function(response){
        var errors =  response.responseJSON.errors;
        for (var campo in errors) {
          $("#listaErrores").append('<li type="square">'+errors[campo]+'</li>');
        }       
      }
  });
}
function eliminar(id){
  $.ajax({
    type:"DELETE",
    url: "comidas/"+id,
    data: {
      "_method": 'DELETE',
      "id": id
    },
    success: function(response) {
      mostrarCartel('Registro eliminado correctamente.','alert-success');
      var table = $('#tableComidas').DataTable();
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


