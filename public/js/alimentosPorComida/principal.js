$(document).ready( function () {
  var table = $('#tableAlimentosPorComida').DataTable({
    responsive: true,
    "serverSide":true,
    "ajax": "../comidas/"+ $("#comidaId").val(),
      rowId: "AlimentoPorComidaId",
    "columns": [
      {data: 'AlimentoPorComidaId'},
      {data: 'AlimentoNombre'},
      {data: 'AlimentoPorComidaCantidadNeto'},
      {data: 'UnidadMedidaNombre'},
      {data: 'AlimentoPorComidaCostoTotal'},
      {data: 'btn',orderable:false,sercheable:false},
    ],
    "language": { "url": "../JSON/Spanish_dataTables.json"},
  });

  $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
  
});
  
  function vaciarCampos(){
    $("#alimento").val("");
    $("#cantidad").val("");
  }
  
  function agregar(){
    $("#id").val(0);
    vaciarCampos();
    $("#tituloModal").text("Agregar alimento");
    $("#btnGuardar span").text("Guardar");
  }
  
  
  function guardar(e){
    $("#listaErrores").empty();
    e.preventDefault();
    var id = $("#id").val();
      $.ajax({
        type:'POST',
        url:"../alimentosporcomida",
        dataType:"json",
        data:{
          comidaId : $("#comidaId").val(),
          alimentoId : $("#alimento").val(),
          cantidadNeto: $('#cantidad').val(),
          unidadMedida : $("#unidadMedida").val(),
        },
        success: function(response){
          $('#modal').modal('hide');
          mostrarCartel('Registro agregado correctamente.','alert-success');
          var table = $('#tableAlimentosPorComida').DataTable();
          table.draw();
          },
        error:function(response){
          var errors =  response.responseJSON.errors;
          for (var campo in errors) {  
            $("#listaErrores").append('<li type="square">'+errors[campo]+'</li>');
          }       
        }
      });
  }
  function eliminar(id){
    $.ajax({
      type:"DELETE",
      url: "../alimentosporcomida/"+id,
      data: {
        "_method": 'DELETE',
        "id": id
      },
      success: function(response) {
        mostrarCartel('Registro eliminado correctamente.','alert-success');
        var table = $('#tableAlimentosPorComida').DataTable();
        table.row('#'+id).remove().draw();
      },
      error:function(){
        mostrarCartel('Error al eliminar el registro.','alert-danger');
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
  
  
  
  