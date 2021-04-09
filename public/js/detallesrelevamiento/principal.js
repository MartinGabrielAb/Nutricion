$(document).ready( function () {
    id=$('#relevamientoId').val();
    $('#tableDetallesRelevamiento').DataTable({
          "serverSide":true,
          "ajax": {
              url: '../api/relevamientos/'+id,
              type: 'GET'
          },
          rowId: 'DetalleRelevamientoId',
          "columns": [
            {data: 'DetalleRelevamientoId'},
            {data: 'PacienteNombre'},
            {data: 'TipoPacienteNombre'},
            {data: 'SalaPiezaCamaNombre'},
            {data: 'DetalleRelevamientoFechora'},
            {data: 'DetalleRelevamientoEstado'},
            {data: 'DetalleRelevamientoObservaciones'},
            {data: 'DetalleRelevamientoDiagnostico'},
            {data: 'DetalleRelevamientoAcompaniante'},
            {data: 'Relevador'},
            {data: 'btn',orderable:false,sercheable:false},
          ],
          "language": {
            "url": '../JSON/Spanish_dataTables.json',
          },
          responsive: true,
          columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 1 },
            { responsivePriority: 3, targets: 10 },
            { responsivePriority: 4, targets: 3 },
            { responsivePriority: 5, targets: 2 },
            { responsivePriority: 6, targets: 5 },
            { responsivePriority: 7, targets: 8 },
            { responsivePriority: 8, targets: 4 },
            { responsivePriority: 9, targets: 9 },
            { responsivePriority: 10, targets: 6 },
        ],
        order: [[ 0, "desc" ]],
        order: [[ 5, "desc" ]]
      });
    });