$(document).ready( function () {
  $('#tableAlimentos').DataTable({
        "serverSide":true,
        "ajax": '../api/alimentos',
          rowId: 'AlimentoId',
        "columns": [
          {data: 'AlimentoId'},
          {data: 'AlimentoNombre'},
          {data: 'AlimentoCantidadTotal'},
          {data: 'AlimentoCostoUnitario'},
          {data: 'AlimentoCostoTotal'},
          {data:'btn',orderable:false,sercheable:false},
        ],
        "language": {
          "url": '../JSON/Spanish_dataTables.json',
        },
        responsive: true
    });
  });