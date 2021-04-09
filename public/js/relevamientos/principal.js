$(document).ready( function () {
    $('#tableRelevamientos').DataTable({
          "serverSide":true,
          "ajax": {
              url: '../api/relevamientos',
              type: 'GET'
          },
          rowId: 'RelevamientoId',
          "columns": [
            {data: 'RelevamientoId'},
            {data: 'RelevamientoFecha'},
            {data: 'RelevamientoTurno'},
            {data: 'btn',orderable:false,sercheable:false},
          ],
          "language": {
            "url": '../JSON/Spanish_dataTables.json',
          },
          "order": [[ 1, "desc" ],[2, "desc"]],
          responsive: true
      });
    });