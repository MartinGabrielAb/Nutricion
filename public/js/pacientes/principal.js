$(document).ready( function () {
  //Pacientes: principal
  var table = $('#tablePacientes').DataTable({
    responsive: true,
    "serverSide":true,
    "ajax": "/pacientes",
      rowId: "PacienteId",
    "columns": [
      {data: "PacienteId"},
      {
        data: null,
        render: function ( data, type, row ) {
          return '<a title="Historial del paciente" href=pacientes/'+data.PacienteId+'>'+data.PersonaApellido+', '+data.PersonaNombre+'</a>';
      }},
      {data: "PersonaCuil"},
      {data: "PersonaDireccion"},
      {data: "PersonaEmail"},
      {data: "PersonaTelefono"},
      {
        data: null,
        render: function ( data, type, row ) {
          if (data.PacienteEstado == 1) {
            return '<td><p class="text-success">Activo</p></td>';
          }else{
            return '<td><p class="text-danger">Inactivo</p></td>';
          };
        }
      },
      {data:'btn',orderable:false,sercheable:false},
    ],
    "language": { "url": "../JSON/Spanish_dataTables.json"
  }});

  $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
  
  /*------Funcion para llenar los campos cuando selecciono una fila -----*/ 
  $('#tablePacientes tbody').on( 'click', 'button', function () {
    $("#tituloModal").text("Editar paciente");
    $("#btnGuardar span").text("Editar");
    vaciarCampos();
    var data = table.row( $(this).parents('tr') ).data();
    $("#id").val(data['PacienteId']);
    $("#apellido").val(data['PersonaApellido']);
    $("#nombre").val(data['PersonaNombre']);
    $("#dni").val(data['PersonaCuil']);
    $("#direccion").val(data['PersonaDireccion']);
    $("#email").val(data['PersonaEmail']);
    $("#telefono").val(data['PersonaTelefono']);
  });

  //Pacientes: show
  var id = $('#pacienteId').val();
  var tableShow = $('#tableHistorialPaciente').DataTable({
    responsive: true,
    "serverSide":true,
    "ajax": "/pacientes/"+id,
      rowId: "DetalleRelevamientoId",
    "columns": [
      {data: "DetalleRelevamientoId"},
      {data: "RelevamientoFecha"},
      {data: "RelevamientoTurno"},
      {data: "TipoPacienteNombre"},
      {
        data: null,
        render: function ( data, type, row ) {
          return data.SalaNombre+'/'+data.PiezaNombre+'/'+data.CamaNumero;
      }},
      {
        data: null,
        render: function ( data, type, row ) {
          if(data.DetalleRelevamientoEstado == 1){
            return '<td><p class="text-success">Activo</p></td>';
          }else{
            return '<td><p class="text-danger">Inactivo</p></td>';
          }
      }},
      {data: "DetalleRelevamientoAcompaniante"},
      {data: "DetalleRelevamientoDiagnostico"},
      {data: "DetalleRelevamientoObservaciones"},
      // {data:'btn',orderable:false,sercheable:false},
    ],
    "language": { "url": "../JSON/Spanish_dataTables.json"
  }});
});

//Pacientes: POST AJAX
function guardar(e){
  $("#listaErrores").empty();
  e.preventDefault();
  var id = $("#id").val();
  if(id == 0){
    $.ajax({
      type:'POST',
      url:"personas",
      dataType:"json",
      data:{
        apellido: $('#apellido').val(),
        nombre: $('#nombre').val(),
        dni: $('#dni').val(),
        direccion: $('#direccion').val(),
        email: $('#email').val(),
        telefono: $('#telefono').val(),
      },
      success: function(response){
        $.ajax({
          type: 'POST',
          url: "pacientes",
          dataType: "json",
          data:{
            personaId: response.success[0].PersonaId,
            estado: $('#estado').val(),
          },
          success: function(response){
            $('#modal').modal('hide');
            mostrarCartel('Registro agregado correctamente.','alert-success');
            var table = $('#tablePacientes').DataTable();
            table.draw();
          },
          error: function(response){
            var errors =  response.responseJSON.errors;
            for (var campo in errors) {
              $("#listaErrores").append('<li type="square">'+errors[campo]+'</li>');
            }
          }
        });
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

//Pacientes: PUT AJAX
function editar(id){
  $("#listaErrores").empty();
  $.ajax({
    type:'PUT',
    url:"personas/"+id,
    dataType:"json",
    data:{
      apellido: $('#apellido').val(),
      nombre: $('#nombre').val(),
      dni: $('#dni').val(),
      direccion: $('#direccion').val(),
      email: $('#email').val(),
      telefono: $('#telefono').val(),
    },
    success: function(response){
      $.ajax({
        type: 'PUT',
        url: "pacientes/"+id,
        dataType: "json",
        data:{
          personaId: response.success.PersonaId,
          estado: $('#estado').val(),
        },
        success: function(response){
          $('#modal').modal('hide');
          mostrarCartel('Registro editado correctamente.','alert-success');
          var table = $('#tablePacientes').DataTable();
          table.draw();
        },
        error: function(response){
          var errors =  response.responseJSON.errors;
          for (var campo in errors) {
            $("#listaErrores").append('<li type="square">'+errors[campo]+'</li>');
          }
        }
      });
    },
    error:function(response){
      var errors =  response.responseJSON.errors;
      for (var campo in errors) {
        $("#listaErrores").append('<li type="square">'+errors[campo]+'</li>');
      }       
    }
  });
}

//Pacientes: DELETE AJAX
function eliminar(id){
  $.ajax({
    type:"DELETE",
    url: "pacientes/"+id,
    data: {
      "_method": 'DELETE',
      "id": id
    },
    success: function(response) {
      mostrarCartel('Registro eliminado correctamente.','alert-success');
      var table = $('#tablePacientes').DataTable();
      table.row('#'+id).remove().draw();
    },
    error:function(){
      mostrarCartel('Error al eliminar el registro.','alert-danger');
    }
  });
}

//funciones auxiliares
function vaciarCampos(){
  $("#apellido").val("");
  $("#nombre").val("");
  $("#dni").val("");
  $("#direccion").val("");
  $("#email").val("");
  $("#telefono").val("");
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