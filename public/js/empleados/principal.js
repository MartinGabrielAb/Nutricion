$(document).ready( function () {
    var table = $('#tableEmpleados').DataTable({
      responsive: true,
      "serverSide":true,
      "processing": true,
      "ajax": "/empleados",
        rowId: "EmpleadoId",
      "columns": [
        {data: "EmpleadoApellido"},
        {data: "EmpleadoNombre"},
        {data: "EmpleadoCuil"},
        {data: "EmpleadoDireccion"},
        {data: "EmpleadoEmail"},
        {data: "EmpleadoTelefono"},
        {
          data: null,
          render: function ( data, type, row ) {
            if (data.EmpleadoEstado == 1) {
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
    $('#tableEmpleados tbody').on( 'click', 'button', function () {
      $("#tituloModal").text("Editar empleado");
      $("#btnGuardar span").text("Editar");
      vaciarCampos();
      var data = table.row( $(this).parents('tr') ).data();
      $("#id").val(data['EmpleadoId']);
      $("#apellido").val(data['EmpleadoApellido']);
      $("#nombre").val(data['EmpleadoNombre']);
      $("#cuil").val(data['EmpleadoCuil']);
      $("#direccion").val(data['EmpleadoDireccion']);
      $("#email").val(data['EmpleadoEmail']);
      $("#telefono").val(data['EmpleadoTelefono']);
      $("#estado").val(data['EmpleadoEstado']);

    });
  
    
  });
  
  //Pacientes: POST AJAX
  function guardar(e){
    $("#listaErrores").empty();
    e.preventDefault();
    var id = $("#id").val();
    if(id == 0){
      $.ajax({
        type:'POST',
        url:"empleados",
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
            var table = $('#tableEmpleados').DataTable();
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
      url:"empleados/"+id,
      dataType:"json",
      data:{
        id :id,
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
            var table = $('#tableEmpleados').DataTable();
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
      url: "empleados/"+id,
      data: {
        "_method": 'DELETE',
        "id": id
      },
      success: function(response) {
        mostrarCartel('Registro eliminado correctamente.','alert-success');
        var table = $('#tableEmpleados').DataTable();
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
    $("#tituloModal").text("Agregar empleado");
    $("#btnGuardar span").text("Guardar");
  }
  function mostrarCartel(texto,clase){
      $('#divMensaje').removeClass('alert-success alert-danger');
      $('#divMensaje').fadeIn();
      $('#divMensaje').text(texto);
      $('#divMensaje').addClass(clase);  
      $('#divMensaje').fadeOut(4000);
  }