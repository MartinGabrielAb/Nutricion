$('#btnConfirmarEliminar').click(function(e){ 
    e.preventDefault();
    var id  = $("#historialId").val();
    $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                });
    $.ajax({
            type:'DELETE',
            url:"../historial/"+id,
            dataType:"json",
            success:function(response){
              var data = response.data; 
              $('#modalEliminar').modal('hide');
              $('#divMensaje').addClass('alert-success');
              $('#divMensaje').text('Registro eliminado.');
              $('#divMensaje').fadeOut(4000);
              var tabla = $('#tableRelevamientos').DataTable();
              tabla.draw();
              window.location.href = "../../relevamientos/";
            },
            error:function(err){
              if (err.status == 422) { // when status code is 422, it's a validation issue
                $('#divMensaje').removeClass('alert-success');
                $('#divMensaje').addClass('alert-warning');
                $('#divMensaje').fadeIn().html(err.responseJSON);
                var divErrores = $('#divMensaje');
                divErrores.append('<ul>');
                $.each(err.responseJSON.errors, function (i, error) { 
                    $('#divErrores').append('<li>'+error[0]+'</li>');
                });
                divErrores.append('</ul>');
              // $('#divErrores').addClass('alert-danger');
              // $('#divErrores').text(error.message['errors']);
              }
            },
          });
  });