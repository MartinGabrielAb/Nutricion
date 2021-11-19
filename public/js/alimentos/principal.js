$(document).ready( function () {
  var table = $('#tableAlimentos').DataTable({
    responsive: true,
    "serverSide":true,
    "ajax": "alimentos",
      rowId: "AlimentoId",
    "columns": [
      {data: 'AlimentoId'},
      {data: 'AlimentoNombre'},
      {data: 'AlimentoCantidadTotal'},
      {data:'btn',orderable:false,sercheable:false},
    ],
    "language": { "url": "public/JSON/Spanish_dataTables.json"},
  });

  $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

  /*------Funcion para llenar los campos cuando selecciono una fila -----*/ 
  $('#tableAlimentos tbody').on( 'click', 'button', function () {
    $("#tituloModal").text("Editar comida");
    $("#btnGuardar span").text("Editar");
    vaciarCampos();
    var data = table.row( $(this).parents('tr') ).data();
    $("#id").val(data['AlimentoId']);
    $("#nombre").val(data['AlimentoNombre']);
    $("#unidad").val(data['UnidadMedidaId']).trigger('change');
    if (data['AlimentoPesoPorUnidad'] != null) {
      $("#cantidad_x_un").val(data['AlimentoPesoPorUnidad']);
    }
  });

  $('#cantidad_x_un').hide();
  $('#lbl_cantidad_x_un').hide();
  $('select').on('change', function() {
    $('#cantidad_x_un').hide();
    $('#lbl_cantidad_x_un').hide();
    $('#cantidad_x_un').empty();
    if (this.value == 3) {//cuando es unidad
      $('#cantidad_x_un').show(); 
      $('#lbl_cantidad_x_un').show();
    }
  });
});

function vaciarCampos(){
  $("#nombre").val("");
  $("#unidad").val(0);
  $('#cantidad_x_un').empty();
  $('#cantidad_x_un').hide();
  $('#lbl_cantidad_x_un').hide();
  $("#divEquivalencia").hide();
  $('#listaErrores').empty();
}

function agregar(){
  $("#id").val(0);
  vaciarCampos();
  $("#tituloModal").text("Agregar alimento");
  $("#btnGuardar span").text("Guardar");
}


function guardar(e){
  $("#listaErrores").empty();
  e.preventDefault();
  var id = $("#id").val();
  var peso_x_unidad;
  if ($('#cantidad_x_un').hasClass("hide")) {
    peso_x_unidad = null;
  }else{
    peso_x_unidad = $('#cantidad_x_un').val();
  }
  if(id == 0){
    $.ajax({
      type:'POST',
      url:"alimentos",
      dataType:"json",
      data:{
        nombre: $('#nombre').val(),
        unidad : $('#unidad').val(),
        peso_x_unidad: peso_x_unidad,
      },
      success: function(response){
        $('#modal').modal('hide');
        mostrarCartel('Registro agregado correctamente.','alert-success');
        var table = $('#tableAlimentos').DataTable();
        table.draw();
        },
      error:function(response){
        var errors =  response.responseJSON.errors;
        for (var campo in errors) {
          console.log(errors[campo]);
          $("#listaErrores").append('<li type="square">'+errors[campo]+'</li>');
        }       
      }
    });
  }else{
    editar(id,peso_x_unidad);
  } 
}

// PUT AJAX
function editar(id,peso_x_unidad){
  $("#listaErrores").empty();
  $.ajax({
    type:'PUT',
    url:"alimentos/"+id,
    dataType:"json",
    data:{
      id: id,
      nombre: $('#nombre').val(),
      unidad : $('#unidad').val(),
      peso_x_unidad: peso_x_unidad,
    },
    success: function(response){
      $('#modal').modal('hide');
      mostrarCartel('Registro editado correctamente.','alert-success');
      var table = $('#tableAlimentos').DataTable();
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

function eliminar(id){
  $.ajax({
    type:"DELETE",
    url: "alimentos/"+id,
    data: {
      "_method": 'DELETE',
      "id": id
    },
    success: function(response) {
      mostrarCartel('Registro eliminado correctamente.','alert-success');
      var table = $('#tableAlimentos').DataTable();
      table.row('#'+id).remove().draw();
    },
    error:function(){
      mostrarCartel('El alimento no se puede eliminar porque conforma una de las comidas.','alert-danger');
    }
  });
}
function mostrarCartel(texto,clase){
    $('#divMensaje').removeClass('alert-success alert-danger');
    $('#divMensaje').fadeIn();
    $('#divMensaje').text(texto);
    $('#divMensaje').addClass(clase);  
    $('#divMensaje').fadeOut(4000);
}







  