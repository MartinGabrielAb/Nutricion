$(document).ready( function () {
  var table = $('#tableHistorial').DataTable({
    responsive: true,
    "serverSide":true,
    "ajax": "/historial",
      rowId: "HistorialId",
    "columns": [
      {data: 'HistorialId'},
      {data: 'RelevamientoFecha'},
      {data: 'RelevamientoTurno'},
      {data: 'MenuNombre'},
      {data:'btn',orderable:false,sercheable:false},
    ],
    "language": { "url": "../JSON/Spanish_dataTables.json"},
  });

});








  
