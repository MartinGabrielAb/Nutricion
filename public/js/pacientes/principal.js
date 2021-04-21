$(document).ready( function () {
  //agregar funcionalidad a los botones de acción
  //principal
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
          return '<a title="Historia del paciente" href=pacientes/'+data.PacienteId+'>'+data.PersonaApellido+', '+data.PersonaNombre+'</a>';
      }},
      {data: "PersonaCuil"},
      {data: "PersonaDireccion"},
      {data: "PersonaEmail"},
      {data: "PersonaTelefono"},
      {
        data: null,
        render: function ( data, type, row ) {
          return "<a href='' class='btn btn-sm btn-default'>Editar</a> <button type='button' class='btn btn-sm btn-default'>Alta</button>";
      }},
    ],
    "language": { "url": "../JSON/Spanish_dataTables.json"
  }});

  // $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
  
  // /*------Funcion para llenar los campos cuando selecciono una fila -----*/ 
  // $('#tableSalas tbody').on( 'click', 'button', function () {
  //   $("#tituloModal").text("Editar sala");
  //   $("#btnGuardar span").text("Editar");
  //   vaciarCampos();
  //   var data = table.row( $(this).parents('tr') ).data();
  //   $("#id").val(data['SalaId']);
  //   $("#nombre").val(data['SalaNombre']);
  // });

  //show
  var id = $('#pacienteId').val();
  var table = $('#tableHistorialPaciente').DataTable({
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