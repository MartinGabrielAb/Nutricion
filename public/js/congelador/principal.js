$(document).ready( function () {
    var table = $('#tableCongelador').DataTable({
      responsive: true,
      "serverSide":true,
      "ajax": "/congelador",
        rowId: "CongeladorId",
      "columns": [
        {data: 'CongeladorId'},
        {data: 'ComidaNombre'},
        {data: 'Porciones'},
        {data:'btn',orderable:false,sercheable:false},
      ],
      "language": { "url": "../JSON/Spanish_dataTables.json"},
    });
  
  });
  
  
  
  
  
  
  
  
    
  