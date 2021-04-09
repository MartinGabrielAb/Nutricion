$(document).ready( function () {
  $('#tableHistorial').DataTable({
    "serverSide":true,
    "ajax": '../historial',
      rowId: 'HistorialId',
    "columns": [
      {data: 'HistorialId'},
      {data: 'HistorialFecha'},
      {data: 'HistorialTurno'},
      {data: 'HistorialCantidadPacientes'},
      {data: 'HistorialCostoTotal'},
      {data:'btn',orderable:false,sercheable:false},
    ],
    "language": {
      "url": '../JSON/Spanish_dataTables.json',
    },
    "order": [[ 1, "desc" ],[2 , "desc"]],
    responsive: true
  });
});

