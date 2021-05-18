$(document).ready( function () {

  $('#pacienteId').select2({
    width: 'resolve',
    theme: "classic",
    placeholder: {
      id: '-1', 
      text: "Buscar por Nombre o DNI",
    },
    allowClear: true
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
  $('#divDetalleRelevamiento').on( 'click','button' , function () {
    if($(this).attr('id') == 'editrelevamiento'){
      $('#btnGuardar').attr('disabled',true);
      $('#modal-body-comidas').addClass('d-none');
      $('#modal-footer-comidas').addClass('d-none');
      $('#modal-body').removeClass('d-none');
      $('#modal-footer').removeClass('d-none');
      $("#tituloModal").text("Editar paciente");
      $("#btnGuardar span").text("Editar");
      vaciarCampos();
      $('#id').val(detallerelevamiento.DetalleRelevamientoId);
      $('#pacienteId').val(detallerelevamiento.PacienteCuil).trigger('change');
      $('#diagnosticoId').val(detallerelevamiento.DetalleRelevamientoDiagnostico);
      $('#observacionesId').val(detallerelevamiento.DetalleRelevamientoObservaciones);
      $('#menu').val(detallerelevamiento.MenuId).trigger('change');
      $('#tipoPacienteId').val(detallerelevamiento.TipoPacienteId).trigger('change');
      $('#comidas').addClass('d-none');
      if(detallerelevamiento.DetalleRelevamientoAcompaniante == 1){
        $( "#acompanianteId" ).prop( "checked", true );
      }else{
        $( "#acompanianteId" ).prop( "checked", false );
      }
      if(detallerelevamiento.DetalleRelevamientoVajillaDescartable == 1){
        $( "#vajilladescartable" ).prop( "checked", true );
      }else{
        $( "#vajilladescartable" ).prop( "checked", false );
      }
      if(detallerelevamiento.DetalleRelevamientoAgregado == 1){
        $( "#agregado" ).prop( "checked", true );
      }else{
        $( "#agregado" ).prop( "checked", false );
      }
      menuId = $("#menu").val();
      tipopacienteId = $("#tipoPacienteId").val();
      menuportipopaciente(menuId,tipopacienteId,detallerelevamiento.DetalleRelevamientoId);
    }else if($(this).attr('id') == 'showcomidas'){
      $("#tituloModal").text("Comidas del paciente");
      $('#modal-body').addClass('d-none');
      $('#modal-footer').addClass('d-none');
      $('#modal-body-comidas').empty().removeClass('d-none');
      $('#modal-footer-comidas').removeClass('d-none');
      $('#modal-body-comidas').append('<ul class="list-group"></ul>');
      menuId = $("#menu").val();
      tipopacienteId = $("#tipoPacienteId").val();
      menuportipopaciente(menuId,tipopacienteId,detallerelevamiento.DetalleRelevamientoId);
    }
  });
  //eventos para seleccionar las comidas del menú
  $('#menu').on("select2:select", function(e) { 
    $("#tipoPacienteId").val(-1).trigger('change');
    $('#comidas').empty();
  });
  $('#tipoPacienteId').on("select2:select", function(e) { 
    $('#comidas').addClass('d-none');
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
        paciente: $('#pacienteId').val(),
        cama: $('#camaId').val(),
        diagnostico: $('#diagnosticoId').val(),
        observaciones: $('#observacionesId').val(),
        menu: $('#menu').val(),
        tipopaciente: $('#tipoPacienteId').val(),
        comidas: $('input[name="comidas[]"]:checked').map(function(){return $(this).val();}).get(),
        acompaniante: $('#acompanianteId').is(':checked'),
        vajilladescartable: $('#vajilladescartable').is(':checked'),
        agregado: $('#agregado').is(':checked'),
        user: $('#usuarioId').val(),

      },
      success: function(response){
        camaid = response.success[0];
        $('#modal').modal('hide');
        mostrarCartel('Registro agregado correctamente.','alert-success');
        getDetallerelevamiento(camaid);
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
      paciente: $('#pacienteId').val(),
      cama: $('#camaId').val(),
      diagnostico: $('#diagnosticoId').val(),
      observaciones: $('#observacionesId').val(),
      menu: $('#menu').val(),
      tipopaciente: $('#tipoPacienteId').val(),
      comidas: $('input[name="comidas[]"]:checked').map(function(){return $(this).val();}).get(),
      acompaniante: $('#acompanianteId').is(':checked'),
      vajilladescartable: $('#vajilladescartable').is(':checked'),
      agregado: $('#agregado').is(':checked'),
      user: $('#usuarioId').val(),
      agregado: $('#agregado').val(),
    },
    success: function(response){
      camaid = response.success[0];
      $('#modal').modal('hide');
      mostrarCartel('Registro editado correctamente.','alert-success');
      getDetallerelevamiento(camaid);
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
      camaid = response.success;
      mostrarCartel('Registro eliminado correctamente.','alert-success');
      getDetallerelevamiento(camaid);
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
            $('#btnGuardar').attr('disabled',false);
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
  $("#pacienteId").val(-1).trigger('change');
  $('#diagnosticoId').val("");
  $('#observacionesId').val("");
  $("#menu").val(-1).trigger('change');
  $("#tipoPacienteId").val(-1).trigger('change');
  $('#acompanianteId').prop( "checked", false );
  $('#vajilladescartable').prop( "checked", false );
  $('#agregado').prop( "checked", false );
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
      if(comidamenuportipopaciente.ComidaPorTipoPacientePrincipal == 1){
        html = `<p><input class="form-check-input" type="checkbox" id="comida${comidamenuportipopaciente.ComidaId}" name="comidas[]" value="${comidamenuportipopaciente.ComidaId}" checked>
                  <label class="form-check-label" for="comida${comidamenuportipopaciente.ComidaId}">
                      ${comidamenuportipopaciente.ComidaNombre}
                  </label></p>`;
      }else{
        html = `<p><input class="form-check-input" type="checkbox" id="comida${comidamenuportipopaciente.ComidaId}" name="comidas[]" value="${comidamenuportipopaciente.ComidaId}">
                  <label class="form-check-label" for="comida${comidamenuportipopaciente.ComidaId}">
                      ${comidamenuportipopaciente.ComidaNombre}
                  </label></p>`;
      }
        $('#comidas').append(html);
      if(comidasDelRelevamiento != null && comidasDelRelevamiento.length>0){
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

function elegirvariantes(){
  elementoComidas = $('#comidas');
  if(elementoComidas.hasClass('d-none')){
    $('#comidas').removeClass('d-none');
  }else{
    $('#comidas').addClass('d-none');
  }
}

function getcamas(piezaid){
  $('.clsPiezas').removeClass('bg-secondary');
  $('#btnPiezaid'+piezaid).addClass('bg-secondary');
  $('#divCamas').removeClass('d-flex').addClass('d-none');
  $('#divDetalleRelevamiento').addClass('d-none');
  $.ajax({
    url: '../camas',
    type: 'GET',
    data: {
      piezaId: piezaid,
    },
    success: function(response) {
      camas = response.success;
      $('#divCamas').empty().append('<label class="m-3">Camas: </label>');
      camas.forEach(cama => {
        let html = `
          <button type="button" id="btnCamaid${cama.CamaId}" class="btn btn-sm btn-default clsCamas m-2 pl-3 pr-3" onclick="getDetallerelevamiento(${cama.CamaId})">
            ${cama.CamaNumero}
          </button>
        `;
        $('#divCamas').removeClass('d-none').addClass('d-flex justify-content-center').append(html);
      });
    },
    error:function(){
      mostrarCartel('Error al obtener camas.','alert-danger');
    }
  });
}

function getDetallerelevamiento(camaid){
  $('.clsCamas').removeClass('bg-secondary');
  $('#divDetalleRelevamiento').addClass('d-none');
  $('#btnCamaid'+camaid).addClass('bg-secondary');
  relevamientoid = $('#relevamientoId').val();
  $.ajax({
    url: '../detallesrelevamiento/'+relevamientoId,
    type: 'GET',
    data: {
      camaId: camaid,
      relevamientoId: relevamientoid,
    },
    success: function(response) {
      $('#divDetalleRelevamiento').empty().append('<ul class="list-group w-100"></ul');
      $('#camaId').val(camaid);
      if(response.success){
        detallerelevamiento = response.success;
        relevamientoid = $('#relevamientoId').val();
        html = `
          <li class="list-group-item text-center">
            <button id="showcomidas" type="button" class="btn btn-sm btn-default ml-1 mr-1 pl-3 pr-3" data-toggle="modal"  data-target="#modal" >
              <i title="comidas" class="fas fa-utensils"></i>
            </button>
            <button id="editrelevamiento" type="button" class="btn btn-sm btn-default ml-1 mr-1 pl-3 pr-3" data-toggle="modal"  data-target="#modal" >
              <i class="fas fa-edit"></i>
            </button>
            <button id="deleterelevamiento" class="btn btn-sm btn-default ml-1 mr-1 pl-3 pr-3" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ${(detallerelevamiento.RelevamientoId != relevamientoid) ? 'disabled' : ''}>
              <i class="fas fa-trash"></i>
            </button>
            <a href="../pacientes/${detallerelevamiento.PacienteId}">
              <button id="historiaclinica" class="btn btn-sm btn-default" type="button">
                  Historia clínica
              </button>
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <button class="dropdown-item" onClick ="eliminar(${detallerelevamiento.DetalleRelevamientoId})" ><i class="fas fa-exclamation-circle"></i>Confirmar eliminación</button>
            </div>
          </li>
          <li class="list-group-item text-center">
            ${(detallerelevamiento.RelevamientoId == relevamientoid) ? '<h5 class="text-success m-0">Revisado</h5>' : '<h5 class="text-warning m-0">Info del último relevamiento</h5>'}
          </li>
          <li class="list-group-item text-center">
            <h6>Paciente</h6>
            <p class="m-0">${detallerelevamiento.PacienteApellido}, ${detallerelevamiento.PacienteNombre}</p>
          </li>
          <li class="list-group-item text-center">
            <h6>Menú</h6>
            <p class="m-0">${detallerelevamiento.MenuNombre}</p>
          </li>
          <li class="list-group-item text-center">
            <h6>Regímen</h6>
            <p class="m-0">${detallerelevamiento.TipoPacienteNombre}</p>
          </li>
          <li class="list-group-item text-center">
            <h6>Acompañante</h6>
            <p class="m-0">${(detallerelevamiento.DetalleRelevamientoAcompaniante == 1 ? 'Si' : 'No')}</p>
          </li>
          <li class="list-group-item text-center">
            <h6>Vajilla Descartable</h6>
            <p class="m-0">${(detallerelevamiento.DetalleRelevamientoVajillaDescartable == 1 ? 'Si' : 'No')}</p>
          </li>
          <li class="list-group-item text-center">
            <h6>Agregado</h6>
            <p class="m-0">${(detallerelevamiento.DetalleRelevamientoAgregado == 1 ? 'Si' : 'No')}</p>
          </li>
          <li class="list-group-item text-center">
            <h6>Diagnóstico</h6>
            <p class="m-0">${detallerelevamiento.DetalleRelevamientoDiagnostico}</p>
          </li>
          <li class="list-group-item text-center">
            <h6>Observaciones</h6>
            <p class="m-0">${detallerelevamiento.DetalleRelevamientoObservaciones}</p>
          </li>
          <li class="list-group-item text-center">
            <h6>Hora de registro</h6>
            <p class="m-0">${detallerelevamiento.DetalleRelevamientoHora}</p>
          </li>
          <li class="list-group-item text-center">
            <h6>Relevador</h6>
            <p class="m-0">${detallerelevamiento.Relevador}</p>
          </li>
        `;
      }else{
        html =`
        <li class="list-group-item text-center">
          <button type="button" class="btn btn-sm btn-default ml-1 mr-1 pl-3 pr-3" onclick="agregar()" data-toggle="modal"  data-target="#modal" >
            <i class="fas fa-user-plus"></i>
          </button>
        </li>
        `;
      }
      $('#divDetalleRelevamiento').removeClass('d-none');
      $('#divDetalleRelevamiento ul').append(html);
    },
    error:function(){
      mostrarCartel('Error al seleccionar relevamiento.','alert-danger');
    }
  });
}