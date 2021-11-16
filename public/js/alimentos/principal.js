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
    "language": { "url": "../JSON/Spanish_dataTables.json"},
  });

  $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

  // $("#nombre").change(function(){
  //     $("#alimento").text($("#nombre").val());
  // });

  // $("#unidad").change(function(){
  //   var unidadMedida = $("#unidad option:selected").text();
  //   if(unidadMedida == 'Litro'){
  //     $('#divEquivalencia').show();
  //     $("#medida").text(unidadMedida);
  //   }else{
  //     $('#equivalente').val("");
  //     $('#divEquivalencia').hide();
  //   }
  // });
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
  $("#divEquivalencia").hide();
  $('#listaErrores').empty();
}

function agregar(){
  vaciarCampos();
  $("#tituloModal").text("Agregar alimento");
  $("#btnGuardar span").text("Guardar");
}


function guardar(e){
  $("#listaErrores").empty();
  e.preventDefault();
  var peso_x_unidad;
  if ($('#cantidad_x_un').val() == undefined) {
    peso_x_unidad = null;
  }else{
    peso_x_unidad = $('#cantidad_x_un').val();
  }
  $.ajax({
    type:'POST',
    url:"/alimentos",
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
}

function eliminar(id){
  $.ajax({
    type:"DELETE",
    url: "/alimentos/"+id,
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







  