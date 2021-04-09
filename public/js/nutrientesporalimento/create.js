$( document ).ready(function() {
    $('#labelComprobar').text('');

    $("#btnGuardar").click(function(){
        var alimentoId = $('#alimentoId').val();
        var nutrientes = $('[name="nutrientes[]"]').map(function(){
              // return this.value;
              return{
                nutrienteId : $(this).attr("id"),
                valor : parseFloat(this.value),
              };
            }).get();;
        var verificado = true;
        nutrientes.forEach(function(elemento){
          if (isNaN(elemento.valor) || elemento.valor < 0 || elemento.valor > 5000) {
            verificado = false;
          }
        });
        if (verificado ==true) {
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
            type:'POST',
              url:"../nutrientesporalimento",
              dataType:"json",
              data:{
                      alimentoId: alimentoId,
                      nutrientes: nutrientes,
                  },
           success: function(response) {
            $('#divMensaje').text("Nutrientes agregados correctamente");
            $('#modalAgregar').modal('hide');
            var table = $('#tableNutrientesPorAlimento').DataTable();
                table.draw();
            },
            error:function(){
              $("#labelComprobar").text("ERROR 1");
              }
            });
        }else{
          $('#labelComprobar').text('Los datos no son correctos');
        }
        
    });

  });
