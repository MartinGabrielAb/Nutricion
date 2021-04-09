$(document).ready( function () {
  $('#tableComidas').DataTable({
        "serverSide":true,
        "ajax": {
            url: 'api/comidas',
            type: 'GET'
        },
        rowId: 'ComidaId',
        "columns": [
          {data: 'ComidaId'},
          {data: 'ComidaNombre'},
          {data: 'TipoComidaNombre'},
          {data: 'ComidaCostoTotal'},
          {data: 'btn',orderable:false,sercheable:false},
        ],
          "language": {
          "url": 'JSON/Spanish_dataTables.json',
          },
        responsive: true
    });
  });