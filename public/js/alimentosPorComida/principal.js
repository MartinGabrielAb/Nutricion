$(document).ready( function () {
    var comidaId = $('#comidaId').val();
  $('#tableAlimentosPorComida').DataTable({
        "serverSide":true,
        "ajax": {
            url: '../api/alimentosporcomida/'+comidaId,
            type: 'GET'
        },
        rowId: 'AlimentoPorComidaId',
        "columns": [
          {data: 'AlimentoPorComidaId'},
          {data: 'AlimentoNombre'},
          {data: 'AlimentoPorComidaCantidadNeto'},
          {data: 'UnidadMedidaNombre'},
          {data: 'AlimentoPorComidaCostoTotal'},
          {data: 'btn',orderable:false,sercheable:false},
        ],
        "language": {
          "url": '../JSON/Spanish_dataTables.json',
        },
        responsive: true
    });
    
  });