$(document).ready( function () {
  var alimentoId = $('#alimentoId').val();
  var table = $('#tableAlimentosPorProveedor').DataTable({
    responsive: true,
    "serverSide":true,
    "ajax": "/alimentos/"+alimentoId,
      rowId: "AlimentoPorProveedorId",
    "columns": [
          {data: 'ProveedorNombre'},
          {data: 'AlimentoPorProveedorCantidad'},
          {data: 'AlimentoPorProveedorCantidadUsada'},
          {data: 'AlimentoPorProveedorCosto'},
          {data: 'AlimentoPorProveedorCostoTotal'},
          {data: 'AlimentoPorProveedorFechaEntrada'},
          {data: 'AlimentoPorProveedorVencimiento'},
          {data: null, name: 'AlimentoPorProveedorEstado',
            render: function ( data) {
              return '<span class="text-success">'+(data.AlimentoPorProveedorCantidad - data.AlimentoPorProveedorCantidadUsada)+'</span>';
          }},
         {data: 'btn',orderable:false,sercheable:false},
    ],
    "language": { "url": "../JSON/Spanish_dataTables.json"},
  });

  $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

});

function vaciarCampos(){
  $("#proveedor").val(0);
  $("#costo").val("");
  $("#cantidad").val("");
  $("#vencimiento").val("");
}

function agregar(){
  vaciarCampos();
  $("#tituloModal").text("Agregar alimento");
  $("#btnGuardar span").text("Guardar");
}


function guardar(e){
  $("#listaErrores").empty();
  e.preventDefault();
  $.ajax({
    type:'POST',
    url:"../alimentosporproveedor",
    dataType:"json",
    data:{
      alimentoId :$('#alimentoId').val(),
      proveedor: $('#proveedor').val(),
      costo : $('#costo').val(),
      cantidad: $('#cantidad').val(),
      vencimiento: $('#vencimiento').val(),

    },
    success: function(response){
      $('#modal').modal('hide');
      mostrarCartel('Registro agregado correctamente.','alert-success');
      var table = $('#tableAlimentosPorProveedor').DataTable();
      table.draw();
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

function eliminar(id){
  $.ajax({
    type:"DELETE",
    url: "../alimentosporproveedor/"+id,
    data: {
      "_method": 'DELETE',
    },
    success: function(response) {
      mostrarCartel('Registro eliminado correctamente.','alert-success');
      var table = $('#tableAlimentosPorProveedor').DataTable();
      table.row('#'+id).remove().draw();
    },
    error:function(){
      mostrarCartel('No se puede borrar porque alguna comida usa este alimento.','alert-danger');
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



