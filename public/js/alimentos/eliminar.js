function eliminarAlimento(id){
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
      url: "alimentos/"+id,
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
        var table = $('#tableAlimentos').DataTable();
        table.row('#'+id).remove().draw();
      },
      error:function(){
        $('#divMensaje').addClass('alert-danger');
        $('#divMensaje').text("Este alimento posiblemente esté siendo usado por una comida.");
        $('#divMensaje').fadeOut(4000);
      }
    });
}