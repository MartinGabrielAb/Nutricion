$(document).ready( function () {
    var alimentoId = $('#alimentoId').val();
      $('#tableNutrientes').DataTable({
        "serverSide":true,
        "ajax": {
            url: '../nutrientesporalimento/'+alimentoId,
            type: 'GET'
        },
        "columns": [
          {data: 'NutrienteNombre'},
          {data: 'NutrientePorAlimentoValor'},
        ],
        "language": {
          "url": '../JSON/Spanish_dataTables.json',
        },
        responsive: true
    });

    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

  });

  function guardar(e){
    var nutrientes = $('[name="nutrientes[]"]').map(function(){
      return{
        nutrienteId : $(this).attr("id"),
        valor : parseFloat(this.value),
      };
    }).get();   
    $("#listaErrores").empty();
    e.preventDefault();
    $.ajax({
      type:'POST',
      url:"../nutrientesporalimento",
      dataType:"json",
      data:{
        nutrientes: nutrientes,
        alimentoId : $('#alimentoId').val(),
      },
      success: function(response){
        $('#modal').modal('hide');
        mostrarCartel('Nutrientes agregados correctamente.','alert-success');
        var table = $('#tableNutrientes').DataTable();
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
  }
  
  function mostrarCartel(texto,clase){
    $('#divMensaje').removeClass('alert-success alert-danger');
    $('#divMensaje').fadeIn();
    $('#divMensaje').text(texto);
    $('#divMensaje').addClass(clase);  
    $('#divMensaje').fadeOut(4000);
}

  

