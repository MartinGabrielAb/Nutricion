$(document).ready( function () {
    relevamiento_id = $('#relevamiento_id').val();
    table = $('#salas_por_relevamiento').DataTable({
      responsive: true,
      "serverSide":true,
      "ajax": "../relevamientos/"+relevamiento_id,
      rowId: "SalaId",
      "columns": [
        {data: "SalaId"},
        {data: "SalaNombre"},
        {data:'btn',orderable:false,sercheable:false},
      ],
      "language": { "url": "../JSON/Spanish_dataTables.json"},
      "order": [[ 0, "desc" ]],
    });
  
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    
    /*------Funcion para llenar los campos cuando selecciono una fila -----*/ 
    $('#salas_por_relevamiento tbody').on( 'click', 'button', function () {
      $("#tituloModal").text("Editar relevamiento");
      $("#btnGuardar span").text("Editar");
      vaciarCampos();
      var data = table.row( $(this).parents('tr') ).data();
      $("#id").val(data['RelevamientoPorSalaId']);
      $("#salas").val(data['SalaId']).trigger('change');
    });
  
    //select2
    $('#salas').select2({
      width: 'resolve',
      theme: "classic",
      placeholder: {
            id: '-1', 
            text: "Sala",
          },
      allowClear: true
    });
  });
  //POST AJAX
  function guardar(e){
    $("#listaErrores").empty();
    e.preventDefault();
    var id = $("#id").val();
    if(id == 0){
      $.ajax({
        type:'POST',
        url:"../relevamientoPorSalas",
        dataType:"json",
        data:{
            relevamiento_id: $('#relevamiento_id').val(),
            sala_id: $('#salas').val(),
        },
        success: function(response){
          $('#modal').modal('hide');
          mostrarCartel('Registro agregado correctamente.','alert-success');
          var table = $('#salas_por_relevamiento').DataTable();
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
  //PUT AJAX
  function editar(id){
    $("#relevamientoporsala").empty();
    $.ajax({
      type:'PUT',
      url:"../relevamientoPorSalas/"+id,
      dataType:"json",
      data:{
        relevamiento_id: $('#relevamiento_id').val(),
        sala_id: $('#salas').val(),
      },
      success: function(response){
        $('#modal').modal('hide');
        mostrarCartel('Registro editado correctamente.','alert-success');
        var table = $('#salas_por_relevamiento').DataTable();
        table.draw();
        $('#modalEditar').modal('hide');
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
  //DELETE AJAX
  function eliminar(id){
    $.ajax({
      type:"DELETE",
      url: "../relevamientoPorSalas/"+id,
      data: {
        "_method": 'DELETE',
        "id": id
      },
      success: function(response) {
        mostrarCartel('Registro eliminado correctamente.','alert-success');
        var table = $('#salas_por_relevamiento').DataTable();
        table.row('#'+id).remove().draw();
      },
      error:function(){
        mostrarCartel('Error al eliminar el registro.','alert-danger');
      }
    });
  }
  //funciones auxiliares
  function vaciarCampos(){
    $("#salas").val(-1).trigger('change');
    $("#listaErrores").empty();
  }
  function agregar(){
    $("#id").val(0);
    vaciarCampos();
    $("#tituloModal").text("Agregar Sala");
    $("#btnGuardar span").text("Guardar");
  }
  function mostrarCartel(texto,clase){
    $('#divMensaje').removeClass('alert-success alert-danger');
    $('#divMensaje').fadeIn();
    $('#divMensaje').text(texto);
    $('#divMensaje').addClass(clase);  
    $('#divMensaje').fadeOut(4000);
  }
  