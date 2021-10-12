$(document).ready( function () {
  var table = $('#tableAlimentosPorComida').DataTable({
    responsive: true,
    "serverSide":true,
    "ajax": "../comidas/"+ $("#comidaId").val(),
      rowId: "AlimentoPorComidaId",
    "columns": [
      {data: 'AlimentoPorComidaId'},
      {data: 'AlimentoNombre'},
      {data: null,
        render: function (data, type, row) {
          return row.AlimentoPorComidaCantidadNeto + ' ' + row.UnidadMedidaNombre;
        }},
      {data: null,
        render: function (data, type, row) {
          return row.AlimentoPorComidaCantidadBruta + ' ' + row.UnidadMedidaBruta;
        }},
      {data: 'btn',orderable:false,sercheable:false},
    ],
    "language": { "url": "../JSON/Spanish_dataTables.json"},
  });

  $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
 
  $('#alimento').select2({
    width: 'resolve',
    theme: "classic",
    placeholder: {
      id: '-1', 
      text: 'Buscar por Alimento',
    },
  });

  $('#alimento').on('select2:select', function (e) {
    var data = e.params.data;
    alimento_id = data.id;
    
    $('#un_medida_bruta').empty();
    $('#un_medida_bruta_id').empty();

    unidad_medida_bruta = obtener_un_medida_bruta(alimento_id);
    
    if(unidad_medida_bruta){
      $('#un_medida_bruta').text(unidad_medida_bruta.UnidadMedidaNombre);
      $('#un_medida_bruta_id').text(unidad_medida_bruta.UnidadMedidaId);
    }
  });
  $('#alimento').on('change', function (e) {
    $('#un_medida_bruta').empty();
    $('#un_medida_bruta_id').empty();
  });

});
  
  function vaciarCampos(){
    $("#alimento").val("").trigger('change');
    $("#cantidad").val("");
    $("#listaErrores").empty();
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
          cantidad_bruta : $("#cantidad_bruta").val(),
        },
        success: function(response){
          $('#modal').modal('hide');
          mostrarCartel('Registro agregado correctamente.','alert-success');
          var table = $('#tableAlimentosPorComida').DataTable();
          table.draw();
          llenarNutrientes($("#comidaId").val());
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
        llenarNutrientes($("#comidaId").val());
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
  function obtener_un_medida_bruta(alimento_id){
      var res_unidad_medida_bruta = null;
      if(alimento_id){
        res_unidad_medida_bruta = $.ajax({
          type:'GET',
          url:"../alimentosporcomida/",
          async: false,
          dataType:"json",
          data:{
            alimento_id : alimento_id,
          },
          done: function(response){
            JSON.parse(response);
            return response;
          },
          error:function(){
            $('#un_medida_bruta').text('Error al obtener unidad de medida');
          }
        }).responseJSON;
      }
      return res_unidad_medida_bruta;
  }
  
  
  
  