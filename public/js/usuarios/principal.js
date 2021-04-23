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


















// $(document).ready( function () {
    
//     $('#tableUsuarios').DataTable({
//           "serverSide":true,
//           "ajax": '../api/usuarios',
//             rowId: 'id',
//           "columns": [
//             {data: 'id'},
//             {data: 'name'},
//             {data: 'email'},
//             {data:'btn',orderable:false,sercheable:false},
//           ],
//           "language": {
//           "url": '../JSON/Spanish_dataTables.json',
//           },
//           responsive: true
//       });

//     });

// function eliminarUsuario(id){
//       $('#modalEliminar'+id).modal('hide');
//       $('#divMensaje').removeClass('alert-success alert-danger');
//       $('#divMensaje').fadeIn();
//       $('#divMensaje').text("");
//       $.ajaxSetup({
//               headers: {
//                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//               }
//       });
//       $.ajax({
//         type:"DELETE",
//         url: "usuarios/"+id,
//         data: {
//           "_method": 'DELETE',
//           "id": id
//         },
//         beforeSend: function(response){

//         },
//        success: function(response) {
//           $('#divMensaje').addClass('alert-success');
//           $('#divMensaje').text("Registro eliminado correctamente.");
//           $('#divMensaje').fadeOut(4000);
//           var table = $('#tableUsuarios').DataTable();
//           table.row('#'+id).remove().draw();
//         },
//         error:function(){
//           $('#divMensaje').addClass('alert-danger');
//           $('#divMensaje').text("Error al eliminar el registro.");
//           $('#divMensaje').fadeOut(4000);
//         }
//       });
// }
// function editarUsuario(id){
//       $('#divMensaje').removeClass('alert-success alert-danger');
//       $('#divMensaje').fadeIn();
//       $('#divMensaje').text("");
//       $('#labelComprobar'+id).removeClass('alert-success alert-danger');
//       $('#labelComprobar'+id).fadeIn();
//       $('#labelComprobar'+id).text("");
//       $('#btnGuardar'+id).attr('disabled',true);
//       $.ajaxSetup({
//               headers: {
//                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//               }
//       });
//       $.ajax({
//         type:'GET',
//         url:"getUsuarios",
//         dataType:"json",
//         beforeSend: function(response){
//           $("#labelComprobar"+id).text("Verificando datos...");
//         },
//        success: function(response) {
//           $("#labelComprobar"+id).text("");
//           var nombre = $('#nombreUsuario'+id).val();
//           var email = $('#emailUsuario'+id).val();
//           var password = $('#passwordUsuario'+id).val();
//           var confirma = $('#confirmaUsuario'+id).val();
//           console.log(password);
//           console.log(confirma);
//           var roles = $('[name="roles'+id+'[]"]:checked').map(function(){
//               return this.value;
//             }).get();
//           var devolver = true;
//           for (let index = 0; index < response.usuarios.length; index++){
//             var emailUsuario = response.usuarios[index]['email'];
//             var idUsuario = response.usuarios[index]['id'];
//             if(emailUsuario == email && idUsuario != id){
//               devolver = false;
//               $("#labelEmail"+id).text("El usuario ingresado ya existe");
//               $("#labelEmail"+id).addClass('text-danger');
//               break;
//             }
//             if(nombre == ''){
//               devolver = false;
//               $("#labelNombre"+id).text("Debe ingresar un nombre");
//               $("#labelNombre"+id).addClass('text-danger');
//               break;
//             }
//             if(nombre.length > 60){
//               devolver = false;
//               $("#labelNombre"+id).text("Nombre demasiado largo");
//               $("#labelNombre"+id).addClass('text-danger');
//               break;
//             }
//             if(password == ''){
//               devolver = false;
//               $("#labelPassword"+id).text("Debe ingresar un password");
//               $("#labelPassword"+id).addClass('text-danger');
//               break;
//             }
//             if(password != confirma){
//               devolver = false;
//               $("#labelPassword"+id).text("Los password deben coincidir");
//               $("#labelPassword"+id).addClass('text-danger');
//               break;
//             }
//             if(roles.length == 0){
//               devolver = false;
//               $("#labelRoles"+id).text("Debe seleccionar al menos un rol");
//               $("#labelRoles"+id).addClass('text-danger');
//               break;
//             }
//           }
//           if(devolver == true){
//               $.ajax({
//                 type:'PUT',
//                 url:"usuarios/"+id,
//                 dataType:"json",
//                 data:{
//                   nombre: nombre,
//                   email: email,
//                   password : password,
//                   roles : roles,
//                 },
//                 success: function(response){
//                   $('#labelComprobar'+id).addClass('alert-success');
//                   $('#labelComprobar'+id).text("Registro editado.");
//                   $('#labelComprobar'+id).fadeOut(4000);
//                   $('#salaNombre'+id).val("");
//                   var table = $('#tableUsuarios').DataTable();
//                   table.draw();
//                   $('#modalEditar'+id).modal('hide');
//                   $('#divMensaje').addClass('alert-success');
//                   $('#divMensaje').text("Registro editado correctamente.");
//                   $('#divMensaje').fadeOut(4000);
//                   },
//                 error:function(){
//                   $("#labelComprobar"+id).text("ERROR 2");
//                 },
//               });
//             }
//         },
//         error:function(){
//           $("#labelComprobar"+id).text("ERROR 1");
//           devolver = false;
//         },
//       });

//     $("#nombreUsuario"+id).click(function(){
//     $('#labelNombre'+id).removeClass('text-danger');
//     $('#labelNombre'+id).text('Nombre');
//     $('#btnGuardar'+id).attr('disabled',false);
//   });
//   $("#emailUsuario"+id).click(function(){
//     $('#labelEmail'+id).removeClass('text-danger');
//     $('#labelEmail'+id).text('E-mail');
//     $('#btnGuardar'+id).attr('disabled',false);
//   });
//   $("#passwordUsuario"+id).click(function(){
//     $('#labelPassword'+id).removeClass('text-danger');
//     $('#labelPassword'+id).text('Password');
//     $('#btnGuardar'+id).attr('disabled',false);
//   });
//   $("#confirmaUsuario"+id).click(function(){
//     $('#labelPassword'+id).removeClass('text-danger');
//     $('#labelPassword'+id).text('Password');
//     $('#labelConfirma'+id).removeClass('text-danger');
//     $('#labelConfirma'+id).text('Confirma Password');
//     $('#btnGuardar'+id).attr('disabled',false);
//   });
//     $('input[name="roles'+id+'[]"]').click(function(){
//     $('#labelRoles'+id).removeClass('text-danger');
//     $('#labelRoles'+id).text('Roles');
//     $('#btnGuardar'+id).attr('disabled',false);
//   });    
// }