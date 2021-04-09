
$( document ).ready(function() {
  $("#formulario").submit(function(event){
    event.preventDefault();
    $('#btnGuardar').attr('disabled',true);
      $.ajax({
        type:'GET',
        url:"getProfesionales",
        dataType:"json",
        beforeSend: function(response){
          $("#labelComprobar").text("Verificando datos...");
        },
       success: function(response) {
          $("#labelComprobar").text("");
          var cuil = $('input[name="cuil"]').val();
          var matricula = $('input[name="matricula"]').val();
          var devolver = true;
          for (let index = 0; index < response.profesionales.length; index++){
            var cuilProfesional = response.profesionales[index]['PersonaCuil'];
            var matriculaProfesional = response.profesionales[index]['ProfesionalMatricula'];
            if(matriculaProfesional == matricula){
              devolver = false;
              $("#labelMatricula").text("La matricula ingresada ya existe");
              $("#labelMatricula").addClass('text-danger');
              break;
            }
            if(cuilProfesional == cuil){
              devolver = false;
              $("#labelCuil").text("El cuil ingresado ya existe");
              $("#labelCuil").addClass('text-danger');
              break;
            }

          }
          if(devolver == true){
            	$('#formulario').unbind('submit').submit()
            }
        },
        error:function(){
          $("#labelComprobar").text("ERROR");
          devolver = false;
        }
      });
  });
  $("#cuil").click(function(){
    $('#labelCuil').removeClass('text-danger');
    $('#labelCuil').text('Cuil');
    $('#btnGuardar').attr('disabled',false);
  });
  $("#matricula").click(function(){
    $('#labelMatricula').removeClass('text-danger');
    $('#labelMatricula').text('Matrícula');
    $('#btnGuardar').attr('disabled',false);
  });    
});
