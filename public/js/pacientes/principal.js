$(document).ready( function () {
  //Pacientes: principal
  var table = $('#tablePacientes').DataTable({
    responsive: true,
    "serverSide":true,
    "processing": true,

    "ajax": "pacientes",
      rowId: "PacienteId",
    "columns": [
      {data: "PacienteApellido"},
      {data: "PacienteNombre"},
      {data: "PacienteCuil"},
      {data: "PacienteDireccion"},
      {data: "PacienteEmail"},
      {data: "PacienteTelefono"},
      {
        data: null,
        name:"PacienteEstado",
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
    $("#apellido").val(data['PacienteApellido']);
    $("#nombre").val(data['PacienteNombre']);
    $("#cuil").val(data['PacienteCuil']);
    $("#direccion").val(data['PacienteDireccion']);
    $("#email").val(data['PacienteEmail']);
    $("#telefono").val(data['PacienteTelefono']);
    $("#estado").val(data['PacienteEstado']);

  });

  //Pacientes: show
  var id = $('#pacienteId').val();
  var tableShow = $('#tableHistorialPaciente').DataTable({
    responsive: true,
    "serverSide":true,
    "ajax": "pacientes/"+id,
    rowId: "DetalleRelevamientoId",
    "columns": [
      {data: 'DetalleRelevamientoId'},
      {data: 'RelevamientoFecha'},
      {
        data: null,
        render: function ( data, type, row ) {
          return data.PacienteApellido+', '+data.PacienteNombre;
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
              return '<span class="text-warning ml-1">Inactivo</span>';
          }
      }},
      {data: 'Relevador'},
      {data: 'btn',orderable:false,sercheable:false},
    ],
    columnDefs: [
      { responsivePriority: 1, targets: 0 },
      { responsivePriority: 2, targets: 13 },
    ],
    "order": [[ 3, "desc" ]],
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
      url:"pacientes",
      dataType:"json",
      data:{
        apellido: $('#apellido').val(),
        nombre: $('#nombre').val(),
        cuil: $('#cuil').val(),
        direccion: $('#direccion').val(),
        email: $('#email').val(),
        telefono: $('#telefono').val(),
        estado: $('#estado').val(),

      },
      success: function(response){
        $('#modal').modal('hide');
        mostrarCartel('Registro agregado correctamente.','alert-success');
        var table = $('#tablePacientes').DataTable();
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

//Pacientes: PUT AJAX
function editar(id){
  $("#listaErrores").empty();
  $.ajax({
    type:'PUT',
    url:"pacientes/"+id,
    dataType:"json",
    data:{
      id:id,
      apellido: $('#apellido').val(),
      nombre: $('#nombre').val(),
      cuil: $('#cuil').val(),
      direccion: $('#direccion').val(),
      email: $('#email').val(),
      telefono: $('#telefono').val(),
      estado: $('#estado').val(),

    },
    success: function(response){
      $('#modal').modal('hide');
      mostrarCartel('Registro editado correctamente.','alert-success');
      var table = $('#tablePacientes').DataTable();
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

//PacientesShow: DELETE AJAX
function eliminarHistorialPaciente(id){
  $.ajax({
    type:"DELETE",
    url: "../detallesrelevamiento/"+id,
    success: function(response) {
      mostrarCartel('Registro eliminado correctamente.','alert-success');
      var table = $('#tableHistorialPaciente').DataTable();
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
  $("#cuil").val("");
  $("#direccion").val("");
  $("#email").val("");
  $("#telefono").val("");
  $("#estado").val("");
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