$(document).ready( function () {
  var table = $('#tableUsuarios').DataTable({
    responsive: true,
    "serverSide":true,
    "ajax": "/usuarios",
      rowId: "id",
    "columns": [
      {data: "id"},
      {data: "name"},
      {data: "email"},
      {data: "roles"},
      {data:'btn',orderable:false,sercheable:false},
    ],
    "language": { "url": "../JSON/Spanish_dataTables.json"
  }});

  $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
  
  /*------Funcion para llenar los campos cuando selecciono una fila -----*/ 
  $('#tableUsuarios tbody').on( 'click', 'button', function () {
    $("#tituloModal").text("Editar usuario");
    $("#btnGuardar span").text("Editar");
    vaciarCampos();
    var data = table.row( $(this).parents('tr') ).data();
    $("#id").val(data['id']);
    $("#nombre").val(data['name']);
    $("#email").val(data['email']);
    $("#roles").val(data['roles']);
    $("#labelPassword").hide();
    $("#labelConfirmacion").hide();
    $("#password").hide();
    $("#confirmacion").hide();

  });
});

function vaciarCampos(){
  $("#labelPassword").show();
  $("#labelConfirmacion").show();
  $("#password").show();
  $("#confirmacion").show();
  $("#nombre").val("");
  $("#email").val("");
  $("#password").val("");
  $("#confirmacion").val("");
  $("#roles").val([]);
  $("#listaErrores").empty();
}

function agregar(){
  $("#id").val(0);
  vaciarCampos();
  $("#tituloModal").text("Agregar usuario");
  $("#btnGuardar span").text("Guardar");
}


function guardar(e){
  $("#listaErrores").empty();
  e.preventDefault();
  var id = $("#id").val();
  if(id == 0){
    $.ajax({
      type:'POST',
      url:"usuarios",
      dataType:"json",
      data:{
        nombre: $('#nombre').val(),
        email: $('#email').val(),
        password: $('#password').val(),
        confirmacion: $('#confirmacion').val(),
        roles: $('#roles').val(),
      },
      success: function(response){
        $('#modal').modal('hide');
        mostrarCartel('Registro agregado correctamente.','alert-success');
        var table = $('#tableUsuarios').DataTable();
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
    url:"usuarios/"+id,
    dataType:"json",
    data:{
      nombre: $('#nombre').val(),
      email: $('#email').val(),
      password: $('#password').val(),
      confirmacion: $('#confirmacion').val(),
      roles: $('#roles').val(),
    },
    success: function(response){
      $('#modal').modal('hide');
      mostrarCartel('Registro editado correctamente.','alert-success');
      var table = $('#tableUsuarios').DataTable();
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
    url: "usuarios/"+id,
    data: {
      "_method": 'DELETE',
      "id": id
    },
    success: function(response) {
      mostrarCartel('Registro eliminado correctamente.','alert-success');
      var table = $('#tableUsuarios').DataTable();
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




