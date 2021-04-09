$(document).ready( function () {
    
    $('#tableUsuarios').DataTable({
          "serverSide":true,
          "ajax": '../api/usuarios',
            rowId: 'id',
          "columns": [
            {data: 'id'},
            {data: 'name'},
            {data: 'email'},
            {data:'btn',orderable:false,sercheable:false},
          ],
          "language": {
          "url": '../JSON/Spanish_dataTables.json',
          },
          responsive: true
      });

    });

function eliminarUsuario(id){
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
        url: "usuarios/"+id,
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
          var table = $('#tableUsuarios').DataTable();
          table.row('#'+id).remove().draw();
        },
        error:function(){
          $('#divMensaje').addClass('alert-danger');
          $('#divMensaje').text("Error al eliminar el registro.");
          $('#divMensaje').fadeOut(4000);
        }
      });
}
function editarUsuario(id){
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
        url:"getUsuarios",
        dataType:"json",
        beforeSend: function(response){
          $("#labelComprobar"+id).text("Verificando datos...");
        },
       success: function(response) {
          $("#labelComprobar"+id).text("");
          var nombre = $('#nombreUsuario'+id).val();
          var email = $('#emailUsuario'+id).val();
          var password = $('#passwordUsuario'+id).val();
          var confirma = $('#confirmaUsuario'+id).val();
          console.log(password);
          console.log(confirma);
          var roles = $('[name="roles'+id+'[]"]:checked').map(function(){
              return this.value;
            }).get();
          var devolver = true;
          for (let index = 0; index < response.usuarios.length; index++){
            var emailUsuario = response.usuarios[index]['email'];
            var idUsuario = response.usuarios[index]['id'];
            if(emailUsuario == email && idUsuario != id){
              devolver = false;
              $("#labelEmail"+id).text("El usuario ingresado ya existe");
              $("#labelEmail"+id).addClass('text-danger');
              break;
            }
            if(nombre == ''){
              devolver = false;
              $("#labelNombre"+id).text("Debe ingresar un nombre");
              $("#labelNombre"+id).addClass('text-danger');
              break;
            }
            if(nombre.length > 60){
              devolver = false;
              $("#labelNombre"+id).text("Nombre demasiado largo");
              $("#labelNombre"+id).addClass('text-danger');
              break;
            }
            if(password == ''){
              devolver = false;
              $("#labelPassword"+id).text("Debe ingresar un password");
              $("#labelPassword"+id).addClass('text-danger');
              break;
            }
            if(password != confirma){
              devolver = false;
              $("#labelPassword"+id).text("Los password deben coincidir");
              $("#labelPassword"+id).addClass('text-danger');
              break;
            }
            if(roles.length == 0){
              devolver = false;
              $("#labelRoles"+id).text("Debe seleccionar al menos un rol");
              $("#labelRoles"+id).addClass('text-danger');
              break;
            }
          }
          if(devolver == true){
              $.ajax({
                type:'PUT',
                url:"usuarios/"+id,
                dataType:"json",
                data:{
                  nombre: nombre,
                  email: email,
                  password : password,
                  roles : roles,
                },
                success: function(response){
                  $('#labelComprobar'+id).addClass('alert-success');
                  $('#labelComprobar'+id).text("Registro editado.");
                  $('#labelComprobar'+id).fadeOut(4000);
                  $('#salaNombre'+id).val("");
                  var table = $('#tableUsuarios').DataTable();
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

    $("#nombreUsuario"+id).click(function(){
    $('#labelNombre'+id).removeClass('text-danger');
    $('#labelNombre'+id).text('Nombre');
    $('#btnGuardar'+id).attr('disabled',false);
  });
  $("#emailUsuario"+id).click(function(){
    $('#labelEmail'+id).removeClass('text-danger');
    $('#labelEmail'+id).text('E-mail');
    $('#btnGuardar'+id).attr('disabled',false);
  });
  $("#passwordUsuario"+id).click(function(){
    $('#labelPassword'+id).removeClass('text-danger');
    $('#labelPassword'+id).text('Password');
    $('#btnGuardar'+id).attr('disabled',false);
  });
  $("#confirmaUsuario"+id).click(function(){
    $('#labelPassword'+id).removeClass('text-danger');
    $('#labelPassword'+id).text('Password');
    $('#labelConfirma'+id).removeClass('text-danger');
    $('#labelConfirma'+id).text('Confirma Password');
    $('#btnGuardar'+id).attr('disabled',false);
  });
    $('input[name="roles'+id+'[]"]').click(function(){
    $('#labelRoles'+id).removeClass('text-danger');
    $('#labelRoles'+id).text('Roles');
    $('#btnGuardar'+id).attr('disabled',false);
  });    
}