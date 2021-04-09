
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
        url:"salas",
        dataType:"json",
        beforeSend: function(response){
          $("#labelComprobar").text("Verificando datos...");
        },
       success: function(response) {
          $("#labelComprobar").text("");
          var nombre = $('input[name="salaNombre"]').val();
          var devolver = true;
          for (let index = 0; index < response.salas.length; index++){
            if(response.salas[index]['SalaNombre'] == nombre){
              devolver = false;
              $("#labelNombre").text("La sala ingresada ya existe");
              $("#labelNombre").addClass('text-danger');
              break;
            }
          }
          if(devolver == true){
            	$.ajax({
                type:'POST',
                url:"salas",
                dataType:"json",
                data:{
                  salaNombre: $('input[name="salaNombre"]').val(),
                },
                success: function(response){
                  $('#salaNombre').val("");
                  $('#modalAgregar').modal('hide');
                  $('#divMensaje').addClass('alert-success');
                  $('#divMensaje').text("Registro agregado correctamente.");
                  $('#divMensaje').fadeOut(4000);
                  var table = $('#tableSalas').DataTable();
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
  $("#salaNombre").click(function(){
    $('#labelNombre').removeClass('text-danger');
    $('#labelNombre').text('Nombre');
    $('#btnGuardar').attr('disabled',false);
  }); 

  $("#btnAgregar").click(function(){
    $("#labelComprobar").text("");
    $('#labelNombre').removeClass('text-danger');
    $('#labelNombre').text('Nombre');
    $('#salaNombre').val("");
    $('#btnGuardar').attr('disabled',false);
  });   
});
