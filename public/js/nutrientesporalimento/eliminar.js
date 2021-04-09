function eliminarNutrientePorAlimento(id){
    $('#modalEliminar'+id).modal('hide');
    $('#divMensaje').removeClass('alert-success alert-danger');
    $('#divMensaje').fadeIn();
    $('#divMensaje').text("");
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });
    $.ajax({
      type:"DELETE",
      url:"../nutrientesporalimento/"+id,
      data: {
        "_method": 'DELETE',
        "id": id
      },
      beforeSend: function(response){

      },
     success: function(response) {
        $('#divMensaje').addClass('alert-success');
        $('#divMensaje').text("Registro eliminado correctamente.");
        $('#divMensaje').fadeOut(4000);
        var table = $('#tableNutrientesPorAlimento').DataTable();
        table.row('#'+id).remove();
        table.draw();
      },
      error:function(){
        $('#divMensaje').addClass('alert-danger');
        $('#divMensaje').text("Error al eliminar el registro.");
        $('#divMensaje').fadeOut(4000);
      }
    });
}