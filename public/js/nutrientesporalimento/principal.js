$(document).ready( function () {
    var alimentoId = $('#alimentoId').val();
  $('#tableNutrientesPorAlimento').DataTable({
        "serverSide":true,
        "ajax": {
            url: '../api/nutrientesporalimento/'+alimentoId,
            type: 'GET'
        },
        rowId: 'NutrientePorAlimentoId',
        "columns": [
          {data: 'NutrientePorAlimentoId',visible:false},
          {data: 'NutrienteNombre'},
          {data: 'NutrientePorAlimentoValor'},
        ],
        "language": {
          "url": '../JSON/Spanish_dataTables.json',
        },
        responsive: true
    });
  });