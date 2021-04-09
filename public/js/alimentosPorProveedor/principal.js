$(document).ready( function () {
    var alimentoId = $('#alimentoId').val();
  $('#tableAlimentosPorProveedor').DataTable({
        "serverSide":true,
        "ajax": {
            url: '../api/alimentosporproveedor/'+alimentoId,
            type: 'GET'
        },
        rowId: 'AlimentoPorProveedorId',
        "columns": [
          {data: 'AlimentoPorProveedorId'},
          {data: 'ProveedorNombre'},
          {data: 'AlimentoPorProveedorCantidad'},
          {data: 'AlimentoPorProveedorCantidadGramos'},
          {data: 'AlimentoPorProveedorCosto'},
          {data: 'AlimentoPorProveedorCostoTotal'},
          {data: 'AlimentoPorProveedorVencimiento'},
          {data: 'btn',orderable:false,sercheable:false},
        ],
        "language": {
          "url": '../JSON/Spanish_dataTables.json',
        },
        responsive: true
    });
  });