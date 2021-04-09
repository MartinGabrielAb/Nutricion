
$( document ).ready(function() {
  // ------------------------MENU NORMAL ---------------------------
  $("#btnGuardarMenu").click(function(){
      $('#divMensaje').removeClass('alert-success alert-danger');
      $('#divMensaje').fadeIn();
      $('#divMensaje').text("");
      $('#labelComprobarMenu').removeClass('alert-success alert-danger');
      $('#labelComprobarMenu').fadeIn();
      $('#labelComprobarMenu').text("");
      $('#btnGuardarMenu').attr('disabled',true);
      $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
      });
      $.ajax({
        type:'GET',
        url:"getMenues",
        dataType:"json",
        beforeSend: function(response){
          $("#labelComprobarMenu").text("Verificando datos...");
        },
       success: function(response) {
          $("#labelComprobarMenu").text("");
          var nombre = $('input[name="menuNombre"]').val();
          var devolver = true;
          for (let index = 0; index < response.menues.length; index++){
            if(response.menues[index]['MenuNombre'] == nombre){
              devolver = false;
              $("#labelMenu").text("El menú ingresado ya existe");
              $("#labelMenu").addClass('text-danger');
              break;
            }
            if( '' == nombre){
              devolver = false;
              $("#labelMenu").text("Debe completar este campo");
              $("#labelMenu").addClass('text-danger');
              break;
            }
          }
          if(devolver == true){
            	$.ajax({
                type:'POST',
                url:"menu",
                dataType:"json",
                data:{
                  menuNombre: $('input[name="menuNombre"]').val(),
                  menuParticular: "0",
                },
                success: function(response){
                  $('#menuNombre').val("");
                  $('#modalAgregarMenu').modal('hide');
                  $('#divMensaje').addClass('alert-success');
                  $('#divMensaje').text("Registro agregado correctamente.");
                  $('#divMensaje').fadeOut(4000);
                  var table = $('#tableMenues').DataTable();
                  table.draw();
                  },
                error:function(){
                  $("#labelComprobarMenu").text("Error");
                }
              });
            }
        },
        error:function(){
          $("#labelComprobarMenu").text("Error");
          devolver = false;
        }
      });
    });

    // ------------------------AGREGAR MENU PARTICULAR ---------------------------

  $("#btnGuardarParticular").click(function(){
      $('#divMensaje').removeClass('alert-success alert-danger');
      $('#divMensaje').fadeIn();
      $('#divMensaje').text("");
      $('#labelComprobarMenu').removeClass('alert-success alert-danger');
      $('#labelComprobarMenu').fadeIn();
      $('#labelComprobarMenu').text("");
      $('#btnGuardarMenu').attr('disabled',true);
      $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
      });
      $.ajax({
        type:'GET',
        url:"getParticulares",
        dataType:"json",
        beforeSend: function(response){
          $("#labelComprobarParticular").text("Verificando datos...");
        },
       success: function(response) {
          $("#labelComprobarParticular").text("");
          var nombre = $('input[name="particularNombre"]').val();
          var devolver = true;
          for (let index = 0; index < response.particulares.length; index++){
            if(response.particulares[index]['MenuNombre'] == nombre){
              devolver = false;
              $("#labelParticular").text("El menú ingresado ya existe");
              $("#labelParticular").addClass('text-danger');
              break;
            }
            if( '' == nombre){
              devolver = false;
              $("#labelParticular").text("Debe completar este campo");
              $("#labelParticular").addClass('text-danger');
              break;
            }
          }
          if(devolver == true){
              $.ajax({
                type:'POST',
                url:"menu",
                dataType:"json",
                data:{
                  menuNombre: $('input[name="particularNombre"]').val(),
                  menuParticular : "1",
                },
                success: function(response){
                  $('#particularNombre').val("");
                  $('#modalAgregarParticular').modal('hide');
                  $('#divMensaje').addClass('alert-success');
                  $('#divMensaje').text("Registro agregado correctamente.");
                  $('#divMensaje').fadeOut(4000);
                  var table = $('#tableParticulares').DataTable();
                  table.draw();
                  },
                error:function(){
                  $("#labelComprobarParticular").text("Datos invalidos");
                }
              });
            }
        },
        error:function(){
          $("#labelComprobarParticular").text("Error al cargar");
          devolver = false;
        }
      });
    });



  $("#menuNombre").click(function(){
    $('#labelMenu').removeClass('text-danger');
    $('#labelMenu').text('Nombre');
    $('#btnGuardarMenu').attr('disabled',false);
  }); 

   $("#menuParticular").click(function(){
    $('#labelParticular').removeClass('text-danger');
    $('#labelParticular').text('Nombre');
    $('#btnGuardarParticular').attr('disabled',false);
  });


  $("#btnAgregarMenu").click(function(){
    $('#labelMenu').removeClass('text-danger');
    $('#labelMenu').text('Nombre');
    $('#menuNombre').val("");
    $('#btnGuardarMenu').attr('disabled',false);
  });   

  $("#btnAgregarParticular").click(function(){
    $('#labelParticular').removeClass('text-danger');
    $('#labelParticular').text('Nombre');
    $('#particularNombre').val("");
    $('#btnGuardarParticular').attr('disabled',false);
  }); 
});
