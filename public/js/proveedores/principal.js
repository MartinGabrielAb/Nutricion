$(document).ready( function () {
  var table = $('#tableProveedores').DataTable({
    responsive: true,
    "serverSide":true,
    "processing": true,
    "ajax": "/proveedores",
      rowId: "ProveedorId",
    "columns": [
      {data: "ProveedorNombre"},
      {data: "ProveedorCuit"},
      {data: "ProveedorDireccion"},
      {data: "ProveedorEmail"},
      {data: "ProveedorTelefono"},
      {
        data: null,
        render: function ( data, type, row ) {
          if (data.ProveedorEstado == 1) {
            return '<td><p class="text-success">Activo</p></td>';
          }else{
            return '<td><p class="text-danger">Inactivo</p></td>';
          };
        }
      },
      {data:'btn',orderable:false,sercheable:false},
    ],
    "language": { "url": "../JSON/Spanish_dataTables.json"
  }});

  $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
  
  /*------Funcion para llenar los campos cuando selecciono una fila -----*/ 
  $('#tableProveedores tbody').on( 'click', 'button', function () {
    $("#tituloModal").text("Editar proveedor");
    $("#btnGuardar span").text("Editar");
    vaciarCampos();
    var data = table.row( $(this).parents('tr') ).data();
    $("#id").val(data['ProveedorId']);
    $("#nombre").val(data['ProveedorNombre']);
    $("#cuil").val(data['ProveedorCuit']);
    $("#direccion").val(data['ProveedorDireccion']);
    $("#email").val(data['ProveedorEmail']);
    $("#telefono").val(data['ProveedorTelefono']);
    $("#estado").val(data['ProveedorEstado']);

  });

  
});

//Pacientes: POST AJAX
function guardar(e){
  $("#listaErrores").empty();
  e.preventDefault();
  var id = $("#id").val();
  if(id == 0){
    $.ajax({
      type:'POST',
      url:"proveedores",
      dataType:"json",
      data:{
        nombre: $('#nombre').val(),
        cuit: $('#cuil').val(),
        direccion: $('#direccion').val(),
        email: $('#email').val(),
        telefono: $('#telefono').val(),
        estado: $('#estado').val(),

      },
      success: function(response){
          $('#modal').modal('hide');
          mostrarCartel('Registro agregado correctamente.','alert-success');
          var table = $('#tableProveedores').DataTable();
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

//Pacientes: PUT AJAX
function editar(id){
  $("#listaErrores").empty();
  $.ajax({
    type:'PUT',
    url:"proveedores/"+id,
    dataType:"json",
    data:{
      id :id,
      nombre: $('#nombre').val(),
      cuit: $('#cuil').val(),
      direccion: $('#direccion').val(),
      email: $('#email').val(),
      telefono: $('#telefono').val(),
      estado: $('#estado').val(),

    },
    success: function(response){
      $('#modal').modal('hide');
          mostrarCartel('Registro editado correctamente.','alert-success');
          var table = $('#tableProveedores').DataTable();
          table.draw();
    },
    error:function(response){
      var errors =  response.responseJSON.errors;
      for (var campo in errors) {
        $("#listaErrores").append('<li type="square">'+errors[campo]+'</li>');
      }       
    }
  });
}

//Pacientes: DELETE AJAX
function eliminar(id){
  $.ajax({
    type:"DELETE",
    url: "proveedores/"+id,
    data: {
      "_method": 'DELETE',
      "id": id
    },
    success: function(response) {
      mostrarCartel('Registro eliminado correctamente.','alert-success');
      var table = $('#tableProveedores').DataTable();
      table.row('#'+id).remove().draw();
    },
    error:function(){
      mostrarCartel('Error al eliminar el registro.','alert-danger');
    }
  });
}

//funciones auxiliares
function vaciarCampos(){
  $("#nombre").val("");
  $("#cuil").val("");
  $("#direccion").val("");
  $("#email").val("");
  $("#telefono").val("");
  $("#estado").val("");

  $("#listaErrores").empty();
}

function agregar(){
  $("#id").val(0);
  vaciarCampos();
  $("#tituloModal").text("Agregar proveedor");
  $("#btnGuardar span").text("Guardar");
}
function mostrarCartel(texto,clase){
    $('#divMensaje').removeClass('alert-success alert-danger');
    $('#divMensaje').fadeIn();
    $('#divMensaje').text(texto);
    $('#divMensaje').addClass(clase);  
    $('#divMensaje').fadeOut(4000);
}