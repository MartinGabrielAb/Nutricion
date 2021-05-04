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
      {data: 'MenuNombre'},
      {data:  'TipoPacienteNombre'},
      {
        data: null,
        render: function ( data, type, row ) {
          if (data.DetalleRelevamientoAcompaniante == 1) {
            return '<span class="text-success ml-1">Si</span>';
        }else{
            return '<span class="text-danger ml-1">No</span>';
        }
      }},
      {
        data: null,
        render: function ( data, type, row ) {
          if (data.DetalleRelevamientoVajillaDescartable == 1) {
            return '<span class="text-success ml-1">Si</span>';
        }else{
            return '<span class="text-danger ml-1">No</span>';
        }
      }},
      {
        data: null,
        render: function ( data, type, row ) {
          return data.SalaPseudonimo+'/'+data.PiezaPseudonimo+'/'+data.CamaNumero;
      }},
      {data: 'DetalleRelevamientoDiagnostico'},
      {data: 'DetalleRelevamientoObservaciones'},
      {data: 'DetalleRelevamientoHora'},
      {
        data: null,
        render: function ( data, type, row ) {
          if (data.DetalleRelevamientoEstado == 1) {
            return '<span class="text-success ml-1">Activo</span>';
          }else{
              return '<span class="text-danger ml-1">Inactivo</span>';
          }
      }},
      {data: 'Relevador'},
      {data: 'btn',orderable:false,sercheable:false},
    ],
    "language": {
      "url": '../JSON/Spanish_dataTables.json',
    },
    responsive: true,
    columnDefs: [
      { responsivePriority: 1, targets: 0 },
      { responsivePriority: 2, targets: 13 },
      { responsivePriority: 3, targets: 2 },
      { responsivePriority: 4, targets: 3 },
      { responsivePriority: 5, targets: 4 },
      { responsivePriority: 6, targets: 5 },
      { responsivePriority: 7, targets: 6 },
      { responsivePriority: 8, targets: 7 },
      { responsivePriority: 9, targets: 1 },
      { responsivePriority: 10, targets: 11 },
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
  $('#tableDetallesRelevamiento tbody').on( 'click', 'button',function () {
    var data = table.row( $(this).parents('tr') ).data();
    if($(this).attr('id') == 'editrelevamiento'){
      $('#modal-body-comidas').addClass('d-none');
      $('#modal-footer-comidas').addClass('d-none');
      $('#modal-body').removeClass('d-none');
      $('#modal-footer').removeClass('d-none');
      $("#tituloModal").text("Editar paciente");
      $("#btnGuardar span").text("Editar");
      vaciarCampos();
      $('#id').val(data['DetalleRelevamientoId']);
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
    }else{
      $("#tituloModal").text("Comidas del paciente");
      $('#modal-body').addClass('d-none');
      $('#modal-footer').addClass('d-none');
      $('#modal-body-comidas').empty().removeClass('d-none');
      $('#modal-footer-comidas').removeClass('d-none');
      $('#modal-body-comidas').append('<ul class="list-group"></ul>');
    }
    menuId = $("#menu").val();
    tipopacienteId = $("#tipoPacienteId").val();
    menuportipopaciente(menuId,tipopacienteId,data['DetalleRelevamientoId']);
  });
  //eventos para seleccionar las comidas del menú
  $('#menu').on("select2:select", function(e) { 
    $("#tipoPacienteId").val(-1).trigger('change');
    $('#comidas').empty();
  });
  $('#tipoPacienteId').on("select2:select", function(e) { 
    menuId = $("#menu").val();
    tipopacienteId = $("#tipoPacienteId").val();
    if($("#id").val() != 0){
      detallerelevamientoId = $("#id").val();
    }else{
      detallerelevamientoId = null;
    }
    if(menuId != -1){
      menuportipopaciente(menuId,tipopacienteId,detallerelevamientoId);
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
        comidas: $('input[name="comidas[]"]:checked').map(function(){return $(this).val();}).get(),
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
      comidas: $('input[name="comidas[]"]:checked').map(function(){return $(this).val();}).get(),
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

//GET menusportipopaciente
function menuportipopaciente(menu,tipopaciente,detallerelevamientoId = null){
  $.ajax({
    type:"GET",
    url: "../menuportipopaciente/",
    data: {
      "menu": menu,
      "tipopaciente": tipopaciente
    },
    success: function(response) {
      menuportipopacienteComidas = response.success;
      if(detallerelevamientoId){
        $.ajax({
          type:"GET",
          url: "../detrelevamientoporcomida/"+detallerelevamientoId,
          success: function(response) {
            detalleRelevamientoComidas = response.success;
            llenarCheckboxComida(menuportipopacienteComidas,detalleRelevamientoComidas);
          },
          error:function(){
            mostrarCartel('Error al eliminar el registro.','alert-danger');
          }
        });
      }else{
        llenarCheckboxComida(menuportipopacienteComidas,null);
      }
    },
    error:function(){
      mostrarCartel('Error al eliminar el registro.','alert-danger');
    }
  });
}

//GET comidas del relevamiento
function getComidasDelRelevamiento(detalleRelevamientoId){
  $.ajax({
    type:"GET",
    url: "../detrelevamientoporcomida/"+detalleRelevamientoId,
    success: function(response) {
      comidas = response.success;
      return comidas;
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
  $('#comidas').empty();
  $("#listaErrores").empty();
}
function agregar(){
  $("#id").val(0);
  $('#modal-body-comidas').addClass('d-none');
  $('#modal-footer-comidas').addClass('d-none');
  $('#modal-body').removeClass('d-none');
  $('#modal-footer').removeClass('d-none');
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

function llenarCheckboxComida(comidasmenuportipopaciente,comidasDelRelevamiento){
  $('#comidas').empty();
  if(comidasmenuportipopaciente.length>0){
    comidasmenuportipopaciente.forEach(comidamenuportipopaciente => {
      html = `<p><input class="form-check-input" type="checkbox" id="comida${comidamenuportipopaciente.ComidaId}" name="comidas[]" value="${comidamenuportipopaciente.ComidaId}">
                  <label class="form-check-label" for="comida${comidamenuportipopaciente.ComidaId}">
                      ${comidamenuportipopaciente.ComidaNombre}
                  </label></p>`;
        $('#comidas').append(html);
      if(comidasDelRelevamiento != null && comidasDelRelevamiento.length>0){
        console.log(comidasDelRelevamiento);
        comidasDelRelevamiento.forEach(comidadelrelevamiento => {
          if(comidamenuportipopaciente.ComidaId == comidadelrelevamiento.ComidaId){
            $('#comida'+comidadelrelevamiento.ComidaId).attr('checked',true);
            htmlcomidas = `<li class="list-group-item">${comidadelrelevamiento.ComidaNombre}</li>`
            $('#modal-body-comidas ul').append(htmlcomidas);
          }
        });
      }
    });
    if(comidasDelRelevamiento != null && comidasDelRelevamiento.length<1){
      $('#modal-body-comidas ul').append('<li class="list-group-item">No existen Comidas.</li>');
    }
  }else{
    $('#comidas').empty().append("<p>No existen comidas</p>");
  }
  
}