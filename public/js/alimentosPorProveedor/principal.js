$(document).ready( function () {
  var alimentoId = $('#alimentoId').val();
  var table = $('#tableAlimentosPorProveedor').DataTable({
    responsive: true,
    "serverSide":true,
    "ajax": "../alimentos/"+alimentoId,
      rowId: "AlimentoPorProveedorId",
    "columns": [
          {data: 'ProveedorNombre'},
          {data: null, name: 'AlimentoPorProveedorCantidad',
            render: function ( data) {
              return data.AlimentoPorProveedorCantidad + ' ' +data.UnidadMedidaNombre + '(s)';
          }},
          {data: null, name: 'AlimentoPorProveedorCantidadUsada',
            render: function ( data) {
              return data.AlimentoPorProveedorCantidadUsada + ' ' +data.UnidadMedidaNombre + '(s)';
          }},
          {data: null, name: 'AlimentoPorProveedorCosto',
            render: function ( data) {
              var num = data.AlimentoPorProveedorCosto;
              return '$' +num.toFixed(2);
          }},
          {data: null, name: 'AlimentoPorProveedorCostoTotal',
            render: function ( data) {
              var num = data.AlimentoPorProveedorCostoTotal;
              return '$' +num.toFixed(2);
          }},
          {data: 'AlimentoPorProveedorFechaEntrada'},
          {data: 'AlimentoPorProveedorVencimiento'},
          {data: null, name: 'AlimentoPorProveedorEstado',
            render: function ( data) {
              var num = data.AlimentoPorProveedorCantidad - data.AlimentoPorProveedorCantidadUsada;
              return '<span class="text-success">'+num.toFixed(2)+ '</span>' + ' ' +data.UnidadMedidaNombre + '(s)';
          }},
         {data: 'btn',orderable:false,sercheable:false},
    ],
    "language": { "url": "../public/JSON/Spanish_dataTables.json"},
    "columnDefs": [
      { responsivePriority: 1, targets: 0 },
      { responsivePriority: 2, targets: 7 },
      { responsivePriority: 3, targets: 8 }
  ]
  });

  $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

  /*------Funcion para llenar los campos cuando selecciono una fila -----*/ 
  $('#tableAlimentosPorProveedor tbody').on( 'click', 'button', function () {
    $("#tituloModal").text("Editar comida");
    $("#btnGuardar span").text("Editar");
    vaciarCampos();
    var data = table.row( $(this).parents('tr') ).data();
    $("#id").val(data['AlimentoPorProveedorId']);
    $("#proveedor").val(data['ProveedorId']).trigger('change');
    $("#alimentoId").val(data['AlimentoId']);
    var costo_total = ( data['AlimentoPorProveedorCantidad'] * data['AlimentoPorProveedorCosto']);
    $("#costo").val(costo_total.toFixed(2));
    $("#vencimiento").val(data['AlimentoPorProveedorVencimiento']);
  });

});

function vaciarCampos(){
  $("#proveedor").val(0);
  $("#costo").val("");
  $("#cantidad").val("");
  $("#vencimiento").val("");
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
  if ($('#cantidad_x_unidad').val() == undefined) {
    $('#cantidad_x_unidad').val(1)
  }
  var cantidad = ( $('#cantidad').val() * $('#cantidad_x_unidad').val()).toFixed(2);
  var costo = $('#costo').val() / cantidad;
  var id = $("#id").val();
  if(id == 0){
    $.ajax({
      type:'POST',
      url:"../alimentosporproveedor",
      dataType:"json",
      data:{
        alimentoId :$('#alimentoId').val(),
        proveedor: $('#proveedor').val(),
        costo : costo,
        cantidad: cantidad,
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
  }else{
    editar(id,costo,cantidad);
  }
}

 // PUT AJAX
 function editar(id,costo,cantidad){
  console.log(id);
  $("#listaErrores").empty();
  $.ajax({
    type:'PUT',
    url:"../alimentosporproveedor/"+id,
    dataType:"json",
    data:{
      id: id,
      alimentoId :$('#alimentoId').val(),
      proveedor: $('#proveedor').val(),
      costo : costo,
      cantidad: cantidad,
      vencimiento: $('#vencimiento').val(),
    },
    success: function(response){
      $('#modal').modal('hide');
      mostrarCartel('Registro editado correctamente.','alert-success');
      var table = $('#tableAlimentosPorProveedor').DataTable();
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



