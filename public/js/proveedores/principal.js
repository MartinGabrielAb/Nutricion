$(document).ready( function () {
  //------------CARGA LA TABLA---------------
    $('#tableProveedores').DataTable({
          "processing": true,
          "serverSide": true,
          "ajax":{
            "url":"../proveedores",
            "dataType":"json",
          },
            rowId: 'ProveedorId',
          "columns": [
            {data: 'ProveedorId'},
            {data: 'ProveedorNombre'},
            {data: 'ProveedorCuit'},
            {data: 'ProveedorDireccion'},
            {data: 'ProveedorTelefono'},
            {data: 'ProveedorEmail'},
            {data:'btn',orderable:false,sercheable:false},
          ],
          "language": {
          "url": '../JSON/Spanish_dataTables.json',
          },
          responsive: true,
  });
});

//------------BOTON PARA AGREGAR UN REGISTRO---------------
$("body").on("click","#btnAgregar",function(e){
  e.preventDefault();
  $('#tituloModal').html("Agregar Proveedor");
  $('#btnGuardar').html("Registrar");
  $('#id').val('');
  $('#idFormProveedores').trigger("reset");
});

//-------------BOTON PARA EDITAR UN REGISTRO-----------
$("body").on("click","#btnEditar",function(e){
  e.preventDefault();
  var tabla = $('#tableProveedores').DataTable();
  var id = $(this).data('id');
  var datos = tabla.row('#'+id).data();
  $('#tituloModal').html("Editar Proveedor");
  $('#btnGuardar').html("Editar");
  $('#modal-id').modal('show');
  $('#id').val(id);
  $('#nombre').val(datos.ProveedorNombre);
  $('#email').val(datos.ProveedorEmail);
  $('#direccion').val(datos.ProveedorDireccion);
  $('#telefono').val(datos.ProveedorTelefono);
  $('#cuit').val(datos.ProveedorCuit);
});
//-------------BOTON PARA ELIMINAR UN REGISTRO-----------
$("body").on("click","#btnEliminar",function(e){
  e.preventDefault();
  var tabla = $('#tableProveedores').DataTable();
  var id = $(this).data('id');
  var datos = tabla.row('#'+id).data();
  $('#id').val(id);
  $("#nombreProveedor").html(datos.ProveedorNombre);
});

$('#btnGuardar').click(function(e){ 
  e.preventDefault();
  var id  = $("#id").val();
  $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
              });

  //---------EL ID ESTA VACIO ES PORQUE ESTA GUARDANDO UN NUEVO REGISTRO----------
  if (id == '') {   
      $.ajax({
        type:'POST',
        url:"proveedores",
        dataType:"json",
        data:{
            nombre: $('#nombre').val(),
            cuit : $('#cuit').val(),
            direccion : $('#direccion').val(),
            telefono: $('#telefono').val(),
            email:$('#email').val(),
        },
        success:function(response){
          var data = response.data; 
          $('#modal-id').modal('hide');
          $('#idFormProveedores').trigger('reset');
          $('#divMensaje').addClass('alert-success');
          $('#divMensaje').text('Registro agregado.');
          $('#divMensaje').fadeOut(4000);
          var tabla = $('#tableProveedores').DataTable();
          tabla.draw(); 
        },
        error:function(err){
             if (err.status == 422) { // when status code is 422, it's a validation issue
             $('#divErrores').fadeIn().html(err.responseJSON);
             var divErrores = $('#divErrores');
             divErrores.append('<ul>');
             $.each(err.responseJSON.errors, function (i, error) { 
                $('#divErrores').append('<li>'+error[0]+'</li>');
            });
            divErrores.append('</ul>');
          // $('#divErrores').addClass('alert-danger');
          // $('#divErrores').text(error.message['errors']);
          }
        },
      }); 
  }else{
    //---------------ES PORQUE ESTA EDITANDO UN REGISTRO-----------------
      $.ajax({
          type:'PUT',
          url:"proveedores/"+id,
          dataType:"json",
          data:{
              id: id,
              nombre: $('#nombre').val(),
              cuit : $('#cuit').val(),
              direccion : $('#direccion').val(),
              telefono: $('#telefono').val(),
              email:$('#email').val(),
          },
          success:function(response){
            var data = response.data; 
            $('#modal-id').modal('hide');
            $('#idFormProveedores').trigger('reset');

            $('#divMensaje').addClass('alert-success');
            $('#divMensaje').text('Registro editado.');
            $('#divMensaje').fadeOut(4000);
            var tabla = $('#tableProveedores').DataTable();
            tabla.draw(); 
          },
          error:function(err){
               if (err.status == 422) { // when status code is 422, it's a validation issue
               $('#divErrores').fadeIn().html(err.responseJSON);
               var divErrores = $('#divErrores');
               divErrores.append('<ul>');
               $.each(err.responseJSON.errors, function (i, error) { 
                  $('#divErrores').append('<li>'+error[0]+'</li>');
              });
              divErrores.append('</ul>');
            // $('#divErrores').addClass('alert-danger');
            // $('#divErrores').text(error.message['errors']);
            }
          },
        });
  }
 });

  //--------------------ELIMINAR UN REGISTRO------------------------
  $('#btnConfirmarEliminar').click(function(e){ 
  e.preventDefault();
  var id  = $("#id").val();
  $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
              });
  $.ajax({
          type:'DELETE',
          url:"proveedores/"+id,
          dataType:"json",
          success:function(response){
            var data = response.data; 
            $('#modalEliminar').modal('hide');
            $('#divMensaje').addClass('alert-success');
            $('#divMensaje').text('Registro eliminado.');
            $('#divMensaje').fadeOut(4000);
            var tabla = $('#tableProveedores').DataTable();
            tabla.row('#'+id).remove().draw();
          },
          error:function(err){
               if (err.status == 422) { // when status code is 422, it's a validation issue
               $('#divErrores').fadeIn().html(err.responseJSON);
               var divErrores = $('#divErrores');
               divErrores.append('<ul>');
               $.each(err.responseJSON.errors, function (i, error) { 
                  $('#divErrores').append('<li>'+error[0]+'</li>');
              });
              divErrores.append('</ul>');
            // $('#divErrores').addClass('alert-danger');
            // $('#divErrores').text(error.message['errors']);
            }
          },
        });
});

