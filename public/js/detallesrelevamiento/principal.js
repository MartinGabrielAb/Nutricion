$(document).ready( function () {
  // -------------------- Select 2 ---------------------
  $('#pacienteId').select2({
    width: 'resolve',
    theme: "classic",
    placeholder: {
      id: '-1', 
      text: "Buscar por Nombre o DNI",
    },
    allowClear: true
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
  $('.clsComidas').select2({
    width: 'resolve',
    theme: "classic",
    placeholder: {
      id: '-1', 
      text: 'Buscar',
    },
    allowClear: true,
  });
  $('#colacion').select2({
    width: 'resolve',
    theme: "classic",
    placeholder: {
      id: '-1', 
      text: 'Buscar',
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
      pantalla_select_paciente();
      $('#id').val(detallerelevamiento.DetalleRelevamientoId);
      $('#pacienteId').val(detallerelevamiento.PacienteCuil).trigger('change');
      $('#diagnosticoId').val(detallerelevamiento.DetalleRelevamientoDiagnostico);
      $('#observacionesId').val(detallerelevamiento.DetalleRelevamientoObservaciones);
      $('#menu').val(detallerelevamiento.MenuId).trigger('change');
      $('#tipoPacienteId').val(detallerelevamiento.TipoPacienteId).trigger('change');
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
      $('#colacion').val(detallerelevamiento.DetalleRelevamientoColacion).trigger('change');
      menuId = $("#menu").val();
      tipopacienteId = $("#tipoPacienteId").val();
      menuportipopaciente(menuId,tipopacienteId,detallerelevamiento.DetalleRelevamientoId);
      seleccionar_comidas(detallerelevamiento.DetalleRelevamientoId);
    }else if($(this).attr('id') == 'showcomidas'){
      $("#tituloModal").text("Comidas del paciente");
      $('#modal-body').addClass('d-none');
      $('#modal-footer').addClass('d-none');
      $('#modal-body-comidas').empty().removeClass('d-none');
      $('#modal-footer-comidas').removeClass('d-none');
      $('#modal-body-comidas').append('<dl class="list-group"></dl>');
      menuId = $("#menu").val();
      tipopacienteId = $("#tipoPacienteId").val();
      menuportipopaciente(menuId,tipopacienteId,detallerelevamiento.DetalleRelevamientoId);
    }

    // ocultar boton de seleccion de paciente.
    $('#select_paciente').addClass('d-none');
    // ocultar inputs de add_paciente.
    $('.col_add_paciente').addClass('d-none');

    $('body').on('change', '#acompanianteId', function() {
      if ($(this).is(":checked")){
        $('#opciones_acompaniante').removeAttr('hidden');
      }else{
        $('#opciones_acompaniante').attr('hidden',true);
      }
    });

  });
  //eventos para seleccionar las comidas del menú
  $('#menu').on("select2:select", function(e) { 
    $(".clsComidas").val(-1).trigger('change');
  });
  $('#tipoPacienteId').on("select2:select", function(e) { 
    $(".clsComidas").val(-1).trigger('change');
    $('.clsTipoComida').prop('checked',false);
    // $('#comidas').addClass('d-none');
    menuId = $("#menu").val();
    tipopacienteId = $(this).val();
    if(menuId != -1 && $("#tipoPacienteId option:selected").text() != 'Individual'){
      seleccionar_comidas();
      // elementoComidas = $('#comidas');
      // if(elementoComidas.hasClass('d-none')){
      //   $('#comidas').removeClass('d-none');
      //   $('#seleccionar_comidas_individuales').removeClass('d-none');
      //   $('#seleccionar_comidas_no_individuales').addClass('d-none');
      // }
    // }else if(menuId != -1 && $("#tipoPacienteId option:selected").text() != 'Individual'){
    //   seleccionar_comidas();
    }
  });
});

//POST AJAX
function guardar(e){
  $("#listaErrores").empty();
  e.preventDefault();
  var id = $("#id").val();
  comidas = [];
  //Saca los IDs de las comidas seleccionadas.
  clsComidas = $('.clsTipoComida');
  clsComidas.each(function(index, item) {
    var $tipo_paciente_id = $(item).val();
    if ($(item).is(':checked')) {
      $comidaid = $('#comidaid'+$tipo_paciente_id).val();
      $comidaid = {
        'ComidaId' : $comidaid,
      }
      if($comidaid != null){
        comidas.push($comidaid);
      }
    }
  });
  //Saca los IDs de las comidas seleccionadas del acompaniante si existe.
  comidas_acompaniente = [];
  if ($('#acompanianteId').is(':checked')) {
    cls_comidas_acompaniente = $('.cls_tiposcomida');
    cls_comidas_acompaniente.each(function name(index, item) {
      if ($(item).is(':checked')) {
        $tipocomidadid = $(this).attr('id');
        $tipocomidadid = {
          'tipoComidaId' : $tipocomidadid,
        }
        if($tipocomidadid != null){
          comidas_acompaniente.push($tipocomidadid);
        }
      }
    });
  }
  if(comidas.length > 0){
    if(id == 0){
      $.ajax({
        type:'POST',
        url:"../detallesrelevamiento",
        dataType:"json",
        data:{
          relevamientoPorSalaId: $('#relevamientoPorSalaId').val(),
          paciente: $('#pacienteId').val(),
          cama: $('#camaId').val(),
          diagnostico: $('#diagnosticoId').val(),
          observaciones: $('#observacionesId').val(),
          menu: $('#menu').val(),
          tipopaciente: $('#tipoPacienteId').val(),
          comidas: comidas,
          acompaniante: $('#acompanianteId').is(':checked'),
          comidas_acompaniente: comidas_acompaniente,
          vajilladescartable: $('#vajilladescartable').is(':checked'),
          user: $('#usuarioId').val(),
          colacion: $('#colacion').val(),
          paciente_modo_carga: $('#paciente_modo_carga').val(),
          paciente_nombre: $('#paciente_nombre').val(),
          paciente_apellido: $('#paciente_apellido').val(),
          paciente_dni: $('#paciente_dni').val(),
        },
        success: function(response){
          camaid = response.success;
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
      editar(id,comidas,comidas_acompaniente);
    } 
  }else{
    $("#listaErrores").append('<li type="square">Debe seleccionar al menos una comida</li>');
  }
}

//PUT AJAX
function editar(id,comidas,comidas_acompaniente){
  $("#listaErrores").empty();
  $.ajax({
    type:'PUT',
    url:"../detallesrelevamiento/"+id,
    dataType:"json",
    data:{
      relevamientoPorSalaId: $('#relevamientoPorSalaId').val(),
      paciente: $('#pacienteId').val(),
      cama: $('#camaId').val(),
      diagnostico: $('#diagnosticoId').val(),
      observaciones: $('#observacionesId').val(),
      menu: $('#menu').val(),
      tipopaciente: $('#tipoPacienteId').val(),
      comidas: comidas,
      acompaniante: $('#acompanianteId').is(':checked'),
      comidas_acompaniente: comidas_acompaniente,
      vajilladescartable: $('#vajilladescartable').is(':checked'),
      user: $('#usuarioId').val(),
      colacion: $('#colacion').val(),
      paciente_modo_carga: $('#paciente_modo_carga').val(),
      paciente_nombre: $('#paciente_nombre').val(),
      paciente_apellido: $('#paciente_apellido').val(),
      paciente_dni: $('#paciente_dni').val(),
    },
    success: function(response){
      camaid = response.success;
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
            llenarselectcomidas(menuportipopacienteComidas,detalleRelevamientoComidas);
            $('#btnGuardar').attr('disabled',false);
          },
          error:function(){
            mostrarCartel('Error al eliminar el registro.','alert-danger');
          }
        });
      }else{
        llenarselectcomidas(menuportipopacienteComidas,null);
      }
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
  $("#tipoPacienteId").val(-1).trigger('change');
  $("#colacion").val(-1).trigger('change');
  $('#acompanianteId').prop( "checked", false );
  $('#vajilladescartable').prop( "checked", false );
  $(".clsComidas").val(-1).trigger('change');
  $("#listaErrores").empty();
  $('.clsTipoComida').prop('checked',false);
  $('.cls_tiposcomida').prop('checked',false);
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
  camaid = $('#camaId').val();
  getUltimoDetRelevamiento(camaid);
  pantalla_select_paciente();
}
function mostrarCartel(texto,clase){
    $('#divMensaje').removeClass('alert-success alert-danger');
    $('#divMensaje').fadeIn();
    $('#divMensaje').text(texto);
    $('#divMensaje').addClass(clase);  
    $('#divMensaje').fadeOut(4000);
}

function llenarselectcomidas(comidasmenuportipopaciente,comidasDelRelevamiento){
  $(".clsComidas").val(-1).trigger('change');
  if(comidasDelRelevamiento != null && comidasDelRelevamiento.length>0){
    comidasDelRelevamiento.forEach(comidadelrelevamiento => {
      $("#comidaid"+comidadelrelevamiento.TipoComidaId).val(comidadelrelevamiento.ComidaId).trigger('change');
      if(comidadelrelevamiento.para_acompaniante != 1){
        $('#modal-body-comidas dl').append('<dt class="list-group-item">'+comidadelrelevamiento.TipoComidaNombre +'</dt>');
      }else{
        $('#modal-body-comidas dl').append('<dt class="list-group-item">'+comidadelrelevamiento.TipoComidaNombre+'(Acompañante) </dt>');
      }
      $('#modal-body-comidas dl').append('<dd class="list-group-item">'+comidadelrelevamiento.ComidaNombre+'</dd>');
    });
  }
  else{
    if(comidasmenuportipopaciente != null && comidasmenuportipopaciente.length>0){
      comidasmenuportipopaciente.forEach(comidamenuportipopaciente => {
        if(comidamenuportipopaciente.ComidaPorTipoPacientePrincipal == 1){
          $("#comidaid"+comidamenuportipopaciente.TipoComidaId).val(comidamenuportipopaciente.ComidaId).trigger('change');
        }else{
          $("#comidaid"+comidamenuportipopaciente.TipoComidaId).val(-1).trigger('change');
        }
      });
    }
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
  $('#camaId').val(camaid);
  $('.clsCamas').removeClass('bg-secondary');
  $('#divDetalleRelevamiento').addClass('d-none');
  $('#btnCamaid'+camaid).addClass('bg-secondary');
  relevamientoPorSalaId = $('#relevamientoPorSalaId').val();
  $.ajax({
    url: '../detallesrelevamiento/'+relevamientoPorSalaId,
    type: 'GET',
    data: {
      camaId: camaid,
      relevamientoPorSalaId: relevamientoPorSalaId,
      tipoconsulta: 1,
    },
    success: function(response) {
      $('#divDetalleRelevamiento').empty().append('<ul class="list-group w-100"></ul');
      $('#camaId').val(camaid);
      if(response.success){
        detallerelevamiento = response.success;
        relevamientoPorSalaId = $('#relevamientoPorSalaId').val();
        html = `
          <li class="list-group-item text-center">
            <button id="showcomidas" type="button" class="btn btn-sm btn-default ml-1 mr-1 pl-3 pr-3" data-toggle="modal"  data-target="#modal" >
              <i title="comidas" class="fas fa-utensils"></i>
            </button>
            <button id="editrelevamiento" type="button" class="btn btn-sm btn-default ml-1 mr-1 pl-3 pr-3" data-toggle="modal"  data-target="#modal" >
              <i class="fas fa-edit"></i>
            </button>
            <button id="deleterelevamiento" class="btn btn-sm btn-default ml-1 mr-1 pl-3 pr-3" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ${(detallerelevamiento.RelevamientoPorSalaId != relevamientoPorSalaId) ? 'disabled' : ''}>
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
            ${(detallerelevamiento.RelevamientoPorSalaId == relevamientoPorSalaId) && (detallerelevamiento.DetalleRelevamientoEstado == 1) && (detallerelevamiento.DetalleRelevamientoControlado != 1)? '<h5 class="text-success m-0">Relevamiento Activo</h5>' : ''}
            ${(detallerelevamiento.RelevamientoPorSalaId == relevamientoPorSalaId) && (detallerelevamiento.DetalleRelevamientoEstado == 1) && (detallerelevamiento.DetalleRelevamientoControlado == 1)? '<h5 class="text-success m-0">Relevamiento Finalizado</h5>' : ''}
            ${(detallerelevamiento.RelevamientoPorSalaId == relevamientoPorSalaId) && (detallerelevamiento.DetalleRelevamientoEstado == 0) ? '<h5 class="text-danger m-0">Relevamiento Inactivo</h5>' : ''}
            ${(detallerelevamiento.RelevamientoPorSalaId != relevamientoPorSalaId) ? '<h5 class="text-info m-0">Último relevamiento a esta cama</h5>' : ''}
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

function getUltimoDetRelevamiento(camaid, paciente = null){
  $.ajax({
    url: '../detallesrelevamiento/'+relevamientoPorSalaId,
    type: 'GET',
    data: {
      camaId: camaid,
      paciente : paciente,
      relevamientoId: relevamientoPorSalaId,
      tipoconsulta: 2,
    },
    success: function(response) {
      if(response.success){
        detallerelevamiento = response.success;
        vaciarCampos();
        $('#id').val(detallerelevamiento.DetalleRelevamientoId);
        $('#pacienteId').val(detallerelevamiento.PacienteCuil).trigger('change');
        $('#diagnosticoId').val(detallerelevamiento.DetalleRelevamientoDiagnostico);
        $('#observacionesId').val(detallerelevamiento.DetalleRelevamientoObservaciones);
        $('#tipoPacienteId').val(detallerelevamiento.TipoPacienteId).trigger('change');
        // $('#comidas').addClass('d-none');
        seleccionar_comidas(detallerelevamiento.DetalleRelevamientoId);
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
        $('#colacion').val(detallerelevamiento.DetalleRelevamientoColacion).trigger('change'); 
      }else{
        if(paciente != null){
          $('#respuestaUltimoRelevamiento').fadeIn().text('No existe relevamiento anterior.').fadeOut(4000);
        }
      }
    },
    error:function(){
      mostrarCartel('Error al seleccionar relevamiento.','alert-danger');
    }
  }); 
}

function getUltimoDetRelevamientoPaciente(){
  $('#respuestaUltimoRelevamiento').stop().empty();
  paciente = $('#pacienteId option:selected').val();
  getUltimoDetRelevamiento(null,paciente);
}

function pantalla_add_new_paciente(){
  $('.col_add_paciente').removeClass('d-none');
  $('.col_select_paciente').addClass('d-none');
  $('#pacienteId').val(-1).trigger('change');
  $('#add_paciente').addClass('d-none');
  $('#select_paciente').removeClass('d-none');
  $('#ultimoRelevamientoId').addClass('d-none');
  $('#paciente_modo_carga').val('add_new');
  $('#pacienteId').attr('required', false);
  $('#paciente_nombre').val('').attr('required', true);
  $('#paciente_apellido').val('').attr('required', true);
  $('#paciente_dni').val('').attr('required', true);
}
function pantalla_select_paciente(){
  $('.col_select_paciente').removeClass('d-none');
  $('.col_add_paciente').addClass('d-none');
  $('#paciente_nombre').val('');
  $('#paciente_apellido').val('');
  $('#paciente_dni').val('');
  $('#add_paciente').removeClass('d-none');
  $('#select_paciente').addClass('d-none');
  $('#ultimoRelevamientoId').removeClass('d-none');
  $('#paciente_modo_carga').val('select');
  $('#pacienteId').attr('required', true);
  $('#paciente_nombre').val('').attr('required', false);
  $('#paciente_apellido').val('').attr('required', false);
  $('#paciente_dni').val('').attr('required', false);
}
function seleccionar_comidas(detallerelevamientoid){
  $('#seleccionar_comidas_no_individuales').empty();
  if($('#tipoPacienteId option:selected').text() != ''){
    if($('#tipoPacienteId option:selected').text() != 'Individual'){
      // $('#comidas').removeClass('d-none');
      // $('#seleccionar_comidas_individuales').addClass('d-none');
      // $('#seleccionar_comidas_no_individuales').removeClass('d-none');
      menu = $('#menu').val();
      tipopaciente = $('#tipoPacienteId').val();
      $.ajax({
        type:"GET",
        url: "../menuportipopaciente/",
        data: {
          "menu": menu,
          "tipopaciente": tipopaciente
        },
        success: function(response) {
          menuportipopacienteComidas = response.success;
          mostrar_checkbox_comidas(menuportipopacienteComidas,detallerelevamientoid);
        },
        error:function(){
          mostrarCartel('Error al obtener comidas.','alert-danger');
        }
      });
    }
  }
}
function mostrar_checkbox_comidas(comidas,detallerelevamientoid) {
  detalleRelevamientoComidas = $.ajax({
    type:"GET",
    url: "../detrelevamientoporcomida/"+detallerelevamientoid,
    async: false,
    cache: false,
    success: function(response) {
      detalleRelevamientoComidas = response.success;
      return detalleRelevamientoComidas;
    },
    error:function(){
      mostrarCartel('Error al eliminar el registro.','alert-danger');
    }
  }).responseJSON;
  
  comidas.forEach(comida => {
    comida.check = null;
    ((!detallerelevamientoid) ? $('#tipo_comida_'+comida.TipoComidaId).prop('checked', true) : '');
    detalleRelevamientoComidas.success.forEach(element => {
      if(element.ComidaId == comida.ComidaId && element.para_acompaniante != 1){
        comida.check = 1;
      }else if(element.para_acompaniante == 1){
        $('#opciones_acompaniante').attr('hidden',false);
        console.log('#' + element.TipoComidaId + ' .cls_tiposcomida');
        $('#' + element.TipoComidaId).prop('checked',true);;
      }
    });
    if ($('#turno').val() == 'Mañana') {
      if (comida.TipoComidaTurno != 1){
      //   if (comida.check == null) {
      //     html = `
      //       <div class="form-check">
      //         <input class="form-check-input comidas_no_individuales" type="checkbox" value="${comida.ComidaId}" id="comida_id_${comida.ComidaId}" name="comida_id_${comida.ComidaId}">
      //         <label class="form-check-label" for="comida_id_${comida.ComidaId}">
      //           ${comida.TipoComidaNombre} - ${comida.ComidaNombre}
      //         </label>
      //       </div>
      //       `;  
      //   }else{
      //     html = `
      //       <div class="form-check">
      //         <input class="form-check-input comidas_no_individuales" checked type="checkbox" value="${comida.ComidaId}" id="comida_id_${comida.ComidaId}" name="comida_id_${comida.ComidaId}">
      //         <label class="form-check-label" for="comida_id_${comida.ComidaId}">
      //           ${comida.TipoComidaNombre} - ${comida.ComidaNombre}
      //         </label>
      //       </div>
      //       `;
      //   }
      //   $('#seleccionar_comidas_no_individuales').append(html);
      // }
      if (comida.Variante == 1) {
        $('#comidaid'+comida.TipoComidaId).val(comida.ComidaId).trigger('change');
        if (comida.check == 1) {
          $('#tipo_comida_'+comida.TipoComidaId).prop('checked', true); 
        }
      }
    }else if($('#turno').val() == 'Tarde'){
      if (comida.TipoComidaTurno != 0){
        // if (comida.check == null) {
        //   html = `
        //     <div class="form-check">
        //       <input class="form-check-input comidas_no_individuales" type="checkbox" value="${comida.ComidaId}" id="comida_id_${comida.ComidaId}" name="comida_id_${comida.ComidaId}">
        //       <label class="form-check-label" for="comida_id_${comida.ComidaId}">
        //         ${comida.TipoComidaNombre} - ${comida.ComidaNombre}
        //       </label>
        //     </div>
        //     `;  
        // }else{
        //   html = `
        //     <div class="form-check">
        //       <input class="form-check-input comidas_no_individuales" checked type="checkbox" value="${comida.ComidaId}" id="comida_id_${comida.ComidaId}" name="comida_id_${comida.ComidaId}">
        //       <label class="form-check-label" for="comida_id_${comida.ComidaId}">
        //         ${comida.TipoComidaNombre} - ${comida.ComidaNombre}
        //       </label>
        //     </div>
        //     `;
        // }
        // $('#seleccionar_comidas_no_individuales').append(html);
        if (comida.Variante == 1) {
          $('#comidaid'+comida.TipoComidaId).val(comida.ComidaId).trigger('change');
          if (comida.check == 1) {
            $('#tipo_comida_'+comida.TipoComidaId).prop('checked', true); 
          }
        }
      }
    }
  }
  });
}

function main_datos_de_paciente(dni){
  datos_de_paciente_api = get_datos_paciente_de_api(dni);
  datos_paciente_en_interna = get_paciente_en_bd_interna(dni);
  switch (true) {
    case (datos_de_paciente_api && !datos_paciente_en_interna):
      datos_paciente_en_interna = set_datos_de_api_en_bd_interna(datos_de_paciente_api);
      break;
    case (!datos_de_paciente_api && !datos_paciente_en_interna):
      datos_paciente_en_interna = set_dni_en_bd_interna(dni);
      break;
    default:
      break;
  }
  mostrar_datos_de_paciente(datos_de_paciente_api, datos_paciente_en_interna);
}

function get_datos_paciente_de_api(dni){
  //Llama a la API a través de los parámetros de fecha_desde, fecha_hasta, DNI.
  //La fecha_desde y fecha_hasta son parámetros obligatorios.
  //Se tomará como fecha_desde 1990/01/01 y a fecha_hasta: fecha actual del sistema.
  //La API devolverà una lista de objetos JSON.
  //Los objetos contienen: ApellidoyNombre, Edad, FechaIngreso, FechaSalida, HoraIngreso, HoraSalida, MotivoIngreso, MOTIVO, NroDocumento, ObraSocial, Procedencia
  //De la lista devuelta, se tomarà el ùltimo o el objeto que tenga la fecha_desde màs cercana a la fecha actual del sistema.
  fecha_desde = "1990-01-01";
  fecha_hasta = get_fecha_actual();

  var settings = {
    "url": "http://stisalta2.duckdns.org/wssaltasalud/rest/WSDatosPacientes",
    "method": "POST",
    "timeout": 0,
    "headers": {
      "Content-Type": "application/json"
    },
    "data": JSON.stringify({
      "FechaDesde": fecha_desde,
      "FechaHasta": fecha_hasta,
      "NroDocumento": dni
    }),
  };
  
  $.ajax(settings).done(function (response) {
    // console.log(response);
    return response;
  });

}

function get_paciente_en_bd_interna(dni){
  //Select single a la tabla paciente con el DNI como filtro, si encuentra entonces devuelve los datos, sino retorna null.
  var settings = {
    "url": "paciente",
    "method": "POST",
    "timeout": 0,
    "headers": {
      "Content-Type": "application/json"
    },
    "data": JSON.stringify({
      "FechaDesde": fecha_desde,
      "FechaHasta": fecha_hasta,
      "NroDocumento": dni
    }),
  };
  
  $.ajax(settings).done(function (response) {
    // console.log(response);
    return response;
  });
}

function set_dni_en_bd_interna(dni){
  //Setea ùnicamente el DNI en BD interna para continuar de todas formas el relevamiento.
}

function mostrar_datos_de_paciente(datos_de_paciente_api, datos_paciente_en_interna){
  //Interactùa con el HTML para mostrar los datos de paciente obtenidos.
}

function get_fecha_actual(){
  //obtiene la fecha actual del sistema formateada como AAAA-MM-DD
  d = new Date();

  month = d.getMonth()+1;
  day = d.getDate();

  output = d.getFullYear() + '-' +
  (month<10 ? '0' : '') + month + '-' +
  (day<10 ? '0' : '') + day;

  return output;
}