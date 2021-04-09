$( document ).ready(function() {
  $("#btnGuardar").click(function(){
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
        url:"getAlimentos",
        dataType:"json",
        beforeSend: function(response){
          $("#labelComprobar").text("Verificando datos...");
        },
       success: function(response) {
          $("#labelComprobar").text("");
          var nombre = $('input[name="alimentoNombre"]').val();
          var devolver = true;
          for (let index = 0; index < response.alimentos.length; index++){
            if(response.alimentos[index]['AlimentoNombre'] == nombre){
              devolver = false;
              $("#labelNombre").text("La alimento ingresada ya existe");
              $("#labelNombre").addClass('text-danger');
              break;
            }
          }
          if(devolver == true){
            	$.ajax({
                type:'POST',
                url:"alimentos",
                dataType:"json",
                data:{
                  alimentoNombre: $('input[name="alimentoNombre"]').val(),
                  unidadMedidaId : $('select[name="unidadMedidaId"]').val(),
                  equivalenteGramos: $('#alimentoEquivalencia').val(),
                },
                success: function(response){
                    $('#modalAgregar').modal('hide');
                    $('#divMensaje').addClass('alert-success');
                    $('#divMensaje').text("Registro agregado");
                    $('#divMensaje').fadeOut(4000);
                    $('#alimentoNombre').val("");
                    var table = $('#tableAlimentos').DataTable();
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
  $("#alimentoNombre").click(function(){
    $('#labelNombre').removeClass('text-danger');
    $('#labelNombre').text('Nombre');
    $('#btnGuardar').attr('disabled',false);
  }); 

  $("#btnAgregar").click(function(){
    $('#labelNombre').removeClass('text-danger');
    $('#labelNombre').text('Nombre');
    $('#alimentoNombre').val("");
    $('#btnGuardar').attr('disabled',false);
  });   

  $("#unidadMedida").change(function(){
    var alimento = $("#alimentoNombre").val();
    var unidadMedida = $("#unidadMedida option:selected").text();
    if(unidadMedida == 'Litro' && alimento != ''){
      $('#divEquivalencia').removeClass('d-none');
      $("#labelUnidadMedida").text("1 "+unidadMedida+ " de "+alimento+" es equivalente a");
    }else{
      $('#divEquivalencia').addClass('d-none');
    }
    
  });

  $("#alimentoNombre").blur(function(){
    var alimento = $("#alimentoNombre").val();
    var unidadMedida = $("#unidadMedida option:selected").text();
    if(alimento == ''){
      $('#divEquivalencia').addClass('d-none');
    }
    if(unidadMedida == 'Litro'){
      $('#divEquivalencia').removeClass('d-none');
      $("#labelUnidadMedida").text("1 "+unidadMedida+ " de "+alimento+" es equivalente a");
    }else{
      $('#divEquivalencia').addClass('d-none');
    }

    
  });
});