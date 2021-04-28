$(document).ready( function () {
  var id=$('#relevamientoId').val();
  var table = $('#tableDetallesRelevamiento').DataTable({
    "serverSide":true,
    "ajax": {
        url: '../detallesrelevamiento',
        type: 'GET',
        data: {
          relevamientoId: id,
        }
    },
    rowId: 'DetalleRelevamientoId',
    "columns": [
      {data: 'DetalleRelevamientoId'},
      {data: 'DetalleRelevamientoTurno'},
      {
        data: null,
        render: function ( data, type, row ) {
          return '<a title="Historial del paciente" href=../pacientes/'+data.PacienteId+'>'+data.PersonaApellido+', '+data.PersonaNombre+'</a>';
      }},
      {data: 'TipoPacienteNombre'},
      {
        data: null,
        render: function ( data, type, row ) {
          return data.SalaPseudonimo+'/'+data.PiezaPseudonimo+'/'+data.CamaNumero;
      }},
      {data: 'DetalleRelevamientoHora'},
      {
        data: null,
        render: function ( data, type, row ) {
          if (data.DetalleRelevamientoEstado == 1) {
            return '<td><p class="text-success">Activo</p></td>';
          }else{
              return '<td><p class="text-danger">Inactivo</p></td>';
          }
      }},
      {data: 'DetalleRelevamientoObservaciones'},
      {data: 'DetalleRelevamientoDiagnostico'},
      {
        data: null,
        render: function ( data, type, row ) {
          if (data.DetalleRelevamientoAcompaniante == 1) {
            return '<td><p class="text-success">Si</p></td>';
        }else{
            return '<td><p class="text-danger">No</p></td>';
        }
      }},
      {
        data: null,
        render: function ( data, type, row ) {
          if (data.DetalleRelevamientoVajillaDescartable == 1) {
            return '<td><p class="text-success">Si</p></td>';
        }else{
            return '<td><p class="text-danger">No</p></td>';
        }
      }},
      {data: 'MenuNombre'},
      {data: 'Relevador'},
      {data: 'btn',orderable:false,sercheable:false},
    ],
    "language": {
      "url": '../JSON/Spanish_dataTables.json',
    },
    responsive: true,
        columnDefs: [
          { responsivePriority: 1, targets: 13 },
      //     { responsivePriority: 2, targets: 1 },
      //     { responsivePriority: 3, targets: 10 },
      //     { responsivePriority: 4, targets: 3 },
      //     { responsivePriority: 5, targets: 2 },
      //     { responsivePriority: 6, targets: 5 },
      //     { responsivePriority: 7, targets: 8 },
      //     { responsivePriority: 8, targets: 4 },
      //     { responsivePriority: 9, targets: 9 },
      //     { responsivePriority: 10, targets: 6 },
      ],
      // order: [[ 0, "desc" ]],
      // order: [[ 5, "desc" ]]
  });
  
  //select2
  $('#turno').select2({
    width: 'resolve',
    theme: "classic",
    placeholder: {
          id: '-1', 
          text: "Turno",
        },
    allowClear: true
  });
  $('#pacienteId').select2({
    width: 'resolve',
    theme: "classic",
    placeholder: {
      id: '-1', 
      text: "Buscar por Nombre o DNI",
    },
    allowClear: true
  });
  $('#camaId').select2({
      width: 'resolve',
      theme: "classic",
      placeholder: {
        id: '-1', 
        text: 'Buscar por "Sala/Pieza/Cama"',
      },
      allowClear: true,
  });
  $('#menu').select2({
    width: 'resolve',
    theme: "classic",
    placeholder: {
      id: '-1', 
      text: 'Buscar por Menú',
    },
    allowClear: true,
});
  $('#tipoPacienteId').select2({
      width: 'resolve',
      theme: "classic",
      placeholder: {
        id: '-1', 
        text: 'Buscar por Tipo de Paciente',
      },
      allowClear: true,
  });

  $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
  
  /*------Funcion para llenar los campos cuando selecciono una fila -----*/ 
  $('#tableDetallesRelevamiento tbody').on( 'click', 'button', function () {
    $("#tituloModal").text("Editar paciente");
    $("#btnGuardar span").text("Editar");
    vaciarCampos();
    var data = table.row( $(this).parents('tr') ).data();
    $('#turno').val(data['DetalleRelevamientoTurno']).trigger('change');
    $('#pacienteId').val(data['PersonaCuil']).trigger('change');
    $('#camaId').val(data['CamaId']).trigger('change');
    $('#diagnosticoId').val(data['DetalleRelevamientoDiagnostico']);
    $('#observacionesId').val(data['DetalleRelevamientoObservaciones']);
    $('#menu').val(data['MenuId']).trigger('change');
    $('#tipoPacienteId').val(data['TipoPacienteId']).trigger('change');
    if(data['DetalleRelevamientoAcompaniante'] == 1){
      $( "#acompanianteId" ).prop( "checked", true );
    }else{
      $( "#acompanianteId" ).prop( "checked", false );
    }
    if(data['DetalleRelevamientoVajillaDescartable'] == 1){
      $( "#vajilladescartable" ).prop( "checked", true );
    }else{
      $( "#vajilladescartable" ).prop( "checked", false );
    }
  });
});

//POST AJAX
function guardar(e){
  $("#listaErrores").empty();
  e.preventDefault();
  var id = $("#id").val();
  if(id == 0){
    $.ajax({
      type:'POST',
      url:"../detallesrelevamiento",
      dataType:"json",
      data:{
        relevamiento: $('#relevamientoId').val(),
        turno: $('#turno').val(),
        paciente: $('#pacienteId').val(),
        cama: $('#camaId').val(),
        diagnostico: $('#diagnosticoId').val(),
        observaciones: $('#observacionesId').val(),
        menu: $('#menu').val(),
        tipopaciente: $('#tipoPacienteId').val(),
        acompaniante: $('#acompanianteId').is(':checked'),
        vajilladescartable: $('#vajilladescartable').is(':checked'),
        user: $('#usuarioId').val(),
      },
      success: function(response){
        $('#modal').modal('hide');
        mostrarCartel('Registro agregado correctamente.','alert-success');
        var table = $('#tableDetallesRelevamiento').DataTable();
        table.draw();
      },
      error:function(response){
        var errors =  response.responseJSON.errors;
        for (var campo in errors) {
          $("#listaErrores").append('<li type="square">'+errors[campo]+'</li>');
        }       
      }
    });
  }else{
    editar(id);
  } 
}

//PUT AJAX
function editar(id){
  $("#listaErrores").empty();
  $.ajax({
    type:'PUT',
    url:"../detallesrelevamiento/"+id,
    dataType:"json",
    data:{
      relevamiento: $('#relevamientoId').val(),
      turno: $('#turno').val(),
      paciente: $('#pacienteId').val(),
      cama: $('#camaId').val(),
      diagnostico: $('#diagnosticoId').val(),
      observaciones: $('#observacionesId').val(),
      menu: $('#menu').val(),
      tipopaciente: $('#tipoPacienteId').val(),
      acompaniante: $('#acompanianteId').is(':checked'),
      vajilladescartable: $('#vajilladescartable').is(':checked'),
      user: $('#usuarioId').val(),
    },
    success: function(response){
      $('#modal').modal('hide');
      mostrarCartel('Registro editado correctamente.','alert-success');
      var table = $('#tableDetallesRelevamiento').DataTable();
      table.draw();
    },
    error:function(response){
      var errors =  response.responseJSON.errors;
      for (var campo in errors) {
        $("#listaErrores").append('<li type="square">'+errors[campo]+'</li>');
      }       
    }
  });
}

//DELETE AJAX
function eliminar(id){
  $.ajax({
    type:"DELETE",
    url: "../detallesrelevamiento/"+id,
    data: {
      "_method": 'DELETE',
      "id": id
    },
    success: function(response) {
      mostrarCartel('Registro eliminado correctamente.','alert-success');
      var table = $('#tableDetallesRelevamiento').DataTable();
      table.row('#'+id).remove().draw();
    },
    error:function(){
      mostrarCartel('Error al eliminar el registro.','alert-danger');
    }
  });
}


//funciones auxiliares
function vaciarCampos(){
  $("#turno").val(-1).trigger('change');
  $("#pacienteId").val(-1).trigger('change');
  $("#camaId").val(-1).trigger('change');
  $('#diagnosticoId').val("");
  $('#observacionesId').val("");
  $("#menu").val(-1).trigger('change');
  $("#tipoPacienteId").val(-1).trigger('change');
  $('#acompanianteId').prop( "checked", false );
  $('#vajilladescartable').prop( "checked", false );
  $("#listaErrores").empty();
}
function agregar(){
  $("#id").val(0);
  vaciarCampos();
  $("#tituloModal").text("Agregar paciente");
  $("#btnGuardar span").text("Guardar");
}
function mostrarCartel(texto,clase){
    $('#divMensaje').removeClass('alert-success alert-danger');
    $('#divMensaje').fadeIn();
    $('#divMensaje').text(texto);
    $('#divMensaje').addClass(clase);  
    $('#divMensaje').fadeOut(4000);
}