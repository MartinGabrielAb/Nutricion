
$( document ).ready(function() {
  $("#formulario").submit(function(event){
    event.preventDefault();
    $('#btnGuardar').attr('disabled',true);
      $.ajax({
        type:'GET',
        url: location.protocol + '//' + location.host + '/public/getPacientes',
        dataType:"json",
        beforeSend: function(response){
          $("#labelComprobar").text("Verificando datos...");
        },
       success: function(response) {
          $("#labelComprobar").text("");
          var cuil = $('input[name="cuil"]').val();
          var cuilViejo = $('input[name="cuilViejo"]').val();
          var devolver = true;
          for (let index = 0; index < response.pacientes.length; index++){
            var cuilPaciente = response.pacientes[index]['PersonaCuil'];
            if(cuilPaciente == cuil){
              if(cuilViejo!=cuilPaciente){
                devolver = false;
                $("#labelCuil").text("El cuil ingresado ya existe");
                $("#labelCuil").addClass('text-danger');
                break;
              }  
            }
          }
          if(devolver == true){
            	$('#formulario').unbind('submit').submit()
            }
        },
        error:function(){
          $("#labelComprobar").text("ERROR get edit");
          devolver = false;
        }
      });
  });
  $("#cuil").click(function(){
    $('#labelCuil').removeClass('text-danger');
    $('#labelCuil').text('Cuil');
    $('#btnGuardar').attr('disabled',false);
  });   
});
