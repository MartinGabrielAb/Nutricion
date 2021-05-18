$(document).ready( function () {
    var rolId = $("#rolId").val();
    var table = $('#tablePermisos').DataTable({
      responsive: true,
      "serverSide":true,
      "ajax": "/roles/"+rolId,
        rowId: "id",
      "columns": [
        {data: "id"},
        {data: "name"},
        {data:'btn',orderable:false,sercheable:false},
      ],
      "language": { "url": "../JSON/Spanish_dataTables.json"
    }});
  
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    
  
  });
  
  function vaciarCampos(){
    $("#permisos").val([]);
    $("#listaErrores").empty();
  }
  
  function agregar(){
    $("#id").val(0);
    vaciarCampos();
    $("#tituloModal").text("Agregar permisos");
    $("#btnGuardar span").text("Guardar");
  }
  
  
  function guardar(e){
    $("#listaErrores").empty();
    e.preventDefault();
      $.ajax({
        type:'POST',
        url:"../permisos",
        dataType:"json",
        data:{
            rol : $("#rolId").val(),
            permisos: $('#permisos').val(),
        },
        success: function(response){
          $('#modal').modal('hide');
          mostrarCartel('Registro(s) agregado(s) correctamente.','alert-success');
          var table = $('#tablePermisos').DataTable();
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
      url: "../permisos/"+id,
      data: {
        "_method": 'DELETE',
        rol : $("#rolId").val(),
      },
      success: function(response) {
        mostrarCartel('Registro eliminado correctamente.','alert-success');
        var table = $('#tablePermisos').DataTable();
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
  
  
  
  