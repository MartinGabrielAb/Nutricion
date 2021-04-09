
$( document ).ready(function() {
  $("#btnGuardar").click(function(){

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
        url:"getUsuarios",
        dataType:"json",
        beforeSend: function(response){
          $("#labelComprobar").text("Verificando datos...");
        },
       success: function(response) {
          $("#labelComprobar").text("");
          var nombre = $('input[name="nombreUsuario"]').val();
          var email = $('input[name="emailUsuario"]').val();
          var password = $('input[name="passwordUsuario"]').val();
          var confirma = $('input[name="confirmaUsuario"]').val();
          var roles = $('[name="roles[]"]:checked').map(function(){
              return this.value;
            }).get();
          var devolver = true;
          for (let index = 0; index < response.usuarios.length; index++){
            if(nombre == ''){
              devolver = false;
              $("#labelNombre").text("Debe ingresar un nombre");
              $("#labelNombre").addClass('text-danger');
              break;
            }
            if(nombre.length > 60){
              devolver = false;
              $("#labelNombre").text("Nombre demasiado largo");
              $("#labelNombre").addClass('text-danger');
              break;
            }
            if(response.usuarios[index]['email'] == email){
              devolver = false;
              $("#labelEmail").text("La usuario ingresado ya existe");
              $("#labelEmail").addClass('text-danger');
              break;
            }
            if(password != confirma){
              devolver = false;
              $("#labelPassword").text("Los password deben coincidir");
              $("#labelPassword").addClass('text-danger');
              break;
            }
            if(roles.length == 0){
              devolver = false;
              $("#labelRoles").text("Debe seleccionar al menos un rol");
              $("#labelRoles").addClass('text-danger');
              break;
            }

          }
          if(devolver == true){
            	$.ajax({
                type:'POST',
                url:"usuarios",
                dataType:"json",
                data:{
                  nombre: nombre,
                  email: email,
                  password : password,
                  roles : roles,
                },
                success: function(response){
                  $('#nombreUsuario').val("");
                  $('#emailUsuario').val("");
                  $('#passwordUsuario').val("");
                  $('#confirmaUsuario').val("");
                  $('#modalAgregar').modal('hide');
                  $('#divMensaje').addClass('alert-success');
                  $('#divMensaje').text("Registro agregado correctamente.");
                  $('#divMensaje').fadeOut(4000);
                  var table = $('#tableUsuarios').DataTable();
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
  $("#nombreUsuario").click(function(){
    $('#labelNombre').removeClass('text-danger');
    $('#labelNombre').text('Nombre');
    $('#btnGuardar').attr('disabled',false);
  });
  $("#emailUsuario").click(function(){
    $('#labelEmail').removeClass('text-danger');
    $('#labelEmail').text('E-mail');
    $('#btnGuardar').attr('disabled',false);
  });
  $("#passwordUsuario").click(function(){
    $('#labelPassword').removeClass('text-danger');
    $('#labelPassword').text('Password');
    $('#btnGuardar').attr('disabled',false);
  });
  $("#confirmaUsuario").click(function(){
    $('#labelPassword').removeClass('text-danger');
    $('#labelPassword').text('Password');
    $('#labelConfirma').removeClass('text-danger');
    $('#labelConfirma').text('Confirma Password');
    $('#btnGuardar').attr('disabled',false);
  });
    $('input[name="roles[]"]').click(function(){
    $('#labelRoles').removeClass('text-danger');
    $('#labelRoles').text('Roles');
    $('#btnGuardar').attr('disabled',false);
  });    

  $("#btnAgregar").click(function(){
    $("#labelComprobar").text("");
    $('#labelNombre').removeClass('text-danger');
    $('#labelNombre').text('Nombre');
    $('#nombreUsuario').val("");
    $('#labelEmail').removeClass('text-danger');
    $('#labelEmail').text('E-mail');
    $('#emailUsuario').val("");
    $('#labelPassword').removeClass('text-danger');
    $('#labelPassword').text('Password');
    $('#passwordUsuario').val("");
    $('#labelConfirma').removeClass('text-danger');
    $('#labelConfirma').text('Confirma Password');
    $('#confirmaUsuario').val("");
    $('#btnGuardar').attr('disabled',false);
  });   
});
