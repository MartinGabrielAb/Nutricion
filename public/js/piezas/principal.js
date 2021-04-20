$(document).ready( function () {
    var SalaId = $("#SalaId").val();
    var table = $('#tablePiezas').DataTable({
      responsive: true,
      "serverSide":true,
      "ajax": "/salas/"+SalaId,
        rowId: "PiezaId",
      "columns": [
        {data: "PiezaId"},
        {data: "PiezaNombre"},
        {data:'btn',orderable:false,sercheable:false},
      ],
      "language": { "url": "../JSON/Spanish_dataTables.json"
    }});
  
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    
    /*------Funcion para llenar los campos cuando selecciono una fila -----*/ 
    $('#tablePiezas tbody').on( 'click', 'button', function () {
      $("#tituloModal").text("Editar pieza");
      $("#btnGuardar span").text("Editar");
      vaciarCampos();
      var data = table.row( $(this).parents('tr') ).data();
      $("#id").val(data['PiezaId']);
      $("#nombre").val(data['PiezaNombre']);
    });
  });
  
  function vaciarCampos(){
    $("#nombre").val("");
    $("#listaErrores").empty();
  }
  
  function agregar(){
    $("#id").val(0);
    vaciarCampos();
    $("#tituloModal").text("Agregar pieza");
    $("#btnGuardar span").text("Guardar");
  }
  
  
  function guardar(e){
    e.preventDefault();
    var id = $("#id").val();
    if(id == 0){
      $.ajax({
        type:'POST',
        url:"../piezas",
        dataType:"json",
        data:{
            salaId : $("#SalaId").val(),
            piezaNombre: $('#nombre').val(),
        },
        success: function(response){
          $('#modal').modal('hide');
          mostrarCartel('Registro agregado correctamente.','alert-success');
          var table = $('#tablePiezas').DataTable();
          table.draw();
          },
        error:function(response){
          var errors =  response.responseJSON.errors;
          for (var campo in errors) {  
            $("#listaErrores").append('<li type="square">'+errors[campo]+'</li>');
          }       
        }
      });
    }else{
      editar(id);
    }
    
  }
  function editar(id){
    $.ajax({
      type:'PUT',
      url:"../piezas/"+id,
      dataType:"json",
      data:{
        salaId : $("#SalaId").val(),
        piezaNombre: $('#nombre').val(),
      },
      success: function(response){
        $('#modal').modal('hide');
        mostrarCartel('Registro editado correctamente.','alert-success');
        var table = $('#tablePiezas').DataTable();
        table.draw();
        $('#modalEditar').modal('hide');
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
      url: "../piezas/"+id,
      data: {
        "_method": 'DELETE',
        "id": id
      },
      success: function(response) {
        mostrarCartel('Registro eliminado correctamente.','alert-success');
        var table = $('#tablePiezas').DataTable();
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
  
  
  
  