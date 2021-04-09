var validarNombreComida = true;
$( document ).ready(function() {
    $("#btnGuardar").click(function(){
        var nombreComida = $("#nombreComida").val();
        if(nombreComida == ""){
            validarNombreComida = false;
        }
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
          url:"../getComidas",
          dataType:"json",
          beforeSend: function(response){
            $("#labelComprobar").text("Verificando datos...");
          },
         success: function(response) {
            $("#labelComprobar").text("");
            var nombre = $('input[name="nombreComida"]').val();
            var tipoComida = $('select[name="tipoComida"]').val();
            var devolver = true;
            for (let index = 0; index < response.comidas.length; index++){
              if(response.comidas[index]['ComidaNombre'] == nombre && response.comidas[index]['TipoComidaId'] == tipoComida){
                devolver = false;
                $("#labelNombre").text("La comida ingresada ya existe");
                $("#labelNombre").addClass('text-danger');
                break;
              }
            }
            if(devolver == true && validarNombreComida == true){
                $.ajax({
                  type:'POST',
                  url:"/comidas",
                  dataType:"json",
                  data:{
                    nombreComida: $('input[name="nombreComida"]').val(),
                    tipoComida : $('select[name="tipoComida"]').val(),
                  },
                  success: function(response){
                      $('#modalAgregar').modal('hide');
                      $('#divMensaje').removeAttr('style');
                      $('#divMensaje').addClass('alert-success');
                      $('#divMensaje').text("Registro agregado");
                      $('#divMensaje').fadeOut(4000);
                      $('#nombreComida').val("");
                      var table = $('#tableComidas').DataTable();
                      table.draw();
                      },
                  error:function(){
                    $("#labelComprobar").text("Verifique los campos.");
                  }
                });
              }else{
                $('#labelComprobar').addClass('alert alert-danger');
                $('#labelComprobar').text('Verifique los campos.');
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
    $("#nombreComida").focus(function(){
      $('#btnGuardar').attr('disabled',false);
      $("#labelComprobar").empty();
      $("#labelComprobar").removeClass('alert-danger');
      $("#labelNombre").removeClass('text-danger');
      $("#labelNombre").empty();
    });

    $('body').on('blur', '#nombreComida', function(){
      var nombreComida = $(this).val();
      if(nombreComida == undefined ){
          validarNombreComida = false;
      }else{
          validarNombreComida = true;
      }
    });
  });