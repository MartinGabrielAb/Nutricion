$(document).ready( function () {
    var table = $('#tableCongelador').DataTable({
      responsive: true,
      "serverSide":true,
      "ajax": "congelador",
        rowId: "CongeladorId",
      "columns": [
        {data: 'CongeladorId'},
        {data: 'ComidaNombre'},
        {data: 'Porciones'},
        {data:'btn',orderable:false,sercheable:false},
      ],
      "language": { "url": "../JSON/Spanish_dataTables.json"},
    });
    
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    
    /*------Funcion para llenar los campos cuando selecciono una fila -----*/ 
    $('#tableCongelador tbody').on( 'click', 'button', function () {
      $("#tituloModal").text("Editar comida");
      $("#btnGuardar span").text("Editar");
      vaciarCampos();
      var data = table.row( $(this).parents('tr') ).data();
      $("#id").val(data['CongeladorId']);
      $("#comida_id").val(data['ComidaId']).trigger('change');
      $("#cantidad_id").val(data['Porciones']);
    });
    
    $('#comida_id').select2({
      width: 'resolve',
      theme: "classic",
      placeholder: {
        id: '-1', 
        text: 'Buscar por Comida',
      },
  });

  });
  
  //Pacientes: POST AJAX
  function guardar(e){
    $("#listaErrores").empty();
    e.preventDefault();
    var id = $("#id").val();
    if(id == 0){
      $.ajax({
        type:'POST',
        url:"congelador",
        dataType:"json",
        data:{
          comida_id: $('#comida_id').val(),
          cantidad: $('#cantidad_id').val(),
        },
        success: function(response){
            $('#modal').modal('hide');
            mostrarCartel('Registro agregado correctamente.','alert-success');
            var table = $('#tableCongelador').DataTable();
            table.draw();
        },
        error:function(response){
          $("#listaErrores").append('<li type="square">Registro ya existente</li>');
        }
      });
    }else{
      editar(id);
    } 
  }
  
  //Pacientes: PUT AJAX
  function editar(id){
    $("#listaErrores").empty();
    $.ajax({
      type:'PUT',
      url:"congelador/"+id,
      dataType:"json",
      data:{
        id :id,
        comida_id: $('#comida_id').val(),
        cantidad: $('#cantidad_id').val(),
      },
      success: function(response){
        $('#modal').modal('hide');
        mostrarCartel('Registro editado correctamente.','alert-success');
        var table = $('#tableCongelador').DataTable();
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
  
  //Pacientes: DELETE AJAX
  function eliminar(id){
    $.ajax({
      type:"DELETE",
      url: "congelador/"+id,
      data: {
        "_method": 'DELETE',
        "id": id
      },
      success: function(response) {
        mostrarCartel('Registro eliminado correctamente.','alert-success');
        var table = $('#tableCongelador').DataTable();
        table.row('#'+id).remove().draw();
      },
      error:function(){
        mostrarCartel('Error al eliminar el registro.','alert-danger');
      }
    });
  }
  
  //funciones auxiliares
  function vaciarCampos(){
    $("#comida_id").val("").trigger("change");
    $("#cantidad_id").val("");
    $("#listaErrores").empty();
  }
  
  function agregar(){
    $("#id").val(0);
    vaciarCampos();
    $("#tituloModal").text("Agregar comida");
    $("#btnGuardar span").text("Guardar");
  }
  function mostrarCartel(texto,clase){
      $('#divMensaje').removeClass('alert-success alert-danger');
      $('#divMensaje').fadeIn();
      $('#divMensaje').text(texto);
      $('#divMensaje').addClass(clase);  
      $('#divMensaje').fadeOut(4000);
  }
  
  
  
  
  
  
    
  