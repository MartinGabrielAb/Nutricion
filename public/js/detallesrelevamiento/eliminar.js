function eliminarDetalleRelevamiento(id){
    $('#modalEliminarDetalleRelevamiento'+id).modal('hide');
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
      url:"../detallesrelevamiento/"+id,
      data: {
        "_method": 'DELETE',
        "id": id
      },
      beforeSend: function(response){

      },
     success: function(response) {
        var table = $('#tableDetallesRelevamiento').DataTable();
        table.row('#'+id).remove();
        table.draw();
        $('#divMensaje').addClass('alert-success');
        $('#divMensaje').text("Registro eliminado correctamente.");
        $('#divMensaje').fadeOut(4000);
      },
      error:function(){
        $('#divMensaje').addClass('alert-danger');
        $('#divMensaje').text("Error al eliminar el registro.");
        $('#divMensaje').fadeOut(4000);
      }
    });
}