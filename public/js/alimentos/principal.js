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
  $.ajax({
    type:'POST',
    url:"/alimentos",
    dataType:"json",
    data:{
      nombre: $('#nombre').val(),
      unidad : $('#unidad').val(),
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







  