$(document).ready( function () {
    relevamiento_id = $('#relevamiento_id').val();
    table = $('#salas_por_relevamiento').DataTable({
      responsive: true,
      "serverSide":true,
      "ajax": "../relevamientos/"+relevamiento_id,
      rowId: "SalaId",
      "columns": [
        {data: "SalaId"},
        {data: "SalaNombre"},
        {data:'btn',orderable:false,sercheable:false},
      ],
      "language": { "url": "../public/JSON/Spanish_dataTables.json"},
      "order": [[ 0, "asc" ]],
    });
  
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

  });
  