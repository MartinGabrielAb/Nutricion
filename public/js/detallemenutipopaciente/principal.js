$(document).ready( function () {
    var menuId = $("#menuId").val();
    var table = $('#tableMenuesPorTipoPaciente').DataTable({
      responsive: true,
      "serverSide":true,
      "ajax": "/menu/"+menuId,
        rowId: "DetalleMenuTipoPacienteId",
      "columns": [
        {data: "TipoPacienteNombre"},
        {data:'btn',orderable:false,sercheable:false},
      ],
      "language": { "url": "../JSON/Spanish_dataTables.json"},
    });
  
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    
    /*------Funcion para llenar los campos cuando selecciono una fila -----*/ 

  });
  
  function vaciarCampos(){
    $("#tipoPaciente").val("");
    $("#listaErrores").empty();
  }
  
  function agregar(){
    vaciarCampos();
    $("#tituloModal").text("Agregar menú");
    $("#btnGuardar span").text("Guardar");
  }
  
  
  function guardar(e){
    $("#listaErrores").empty();
    e.preventDefault();
      $.ajax({
        type:'POST',
        url:"../menuportipopaciente",
        dataType:"json",
        data:{
          tipoPaciente: $('#tipoPaciente').val(),
          menuId: $('#menuId').val(),

        },
        success: function(response){
          $('#modal').modal('hide');
          mostrarCartel('Registro agregado correctamente.','alert-success');
          var table = $('#tableMenuesPorTipoPaciente').DataTable();
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
      url: "../menuportipopaciente/"+id,
      data: {
        "_method": 'DELETE',
        "id": id
      },
      success: function(response) {
        mostrarCartel('Registro eliminado correctamente.','alert-success');
        var table = $('#tableMenuesPorTipoPaciente').DataTable();
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
  
  
  
  