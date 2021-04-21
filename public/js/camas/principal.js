$(document).ready( function () {
    var PiezaId = $("#PiezaId").val();
    var table = $('#tableCamas').DataTable({
      responsive: true,
      "serverSide":true,
      "ajax": "/piezas/"+PiezaId,
        rowId: "CamaId",
      "columns": [
        {data: "CamaId"},
        {data: "CamaNumero"},
        {data:"CamaEstado"},
        {data:'btn',orderable:false,sercheable:false},
      ],
      "language": { "url": "../JSON/Spanish_dataTables.json"
    }});
  
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    
    /*------Funcion para llenar los campos cuando selecciono una fila -----*/ 
    $('#tableCamas tbody').on( 'click', 'button', function () {
      $("#tituloModal").text("Editar cama");
      $("#btnGuardar span").text("Editar");
      vaciarCampos();
      var data = table.row( $(this).parents('tr') ).data();
      $("#id").val(data['CamaId']);
      $("#numero").val(data['CamaNumero']);
    });
  });
  
  function vaciarCampos(){
    $("#numero").val("");
    $("#listaErrores").empty();
  }
  
  function agregar(){
    $("#id").val(0);
    vaciarCampos();
    $("#tituloModal").text("Agregar cama");
    $("#btnGuardar span").text("Guardar");
  }
  
  
  function guardar(e){
    $("#listaErrores").empty();
    e.preventDefault();
    var id = $("#id").val();
    if(id == 0){
      $.ajax({
        type:'POST',
        url:"../../camas",
        dataType:"json",
        data:{
            piezaId : $("#PiezaId").val(),
            camaNumero: $('#numero').val(),
        },
        success: function(response){
          $('#modal').modal('hide');
          mostrarCartel('Registro agregado correctamente.','alert-success');
          var table = $('#tableCamas').DataTable();
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
  function editar(id){
    $("#listaErrores").empty();
    $.ajax({
      type:'PUT',
      url:"../../camas/"+id,
      dataType:"json",
      data:{
        piezaId : $("#PiezaId").val(),
      },
      success: function(response){
        $('#modal').modal('hide');
        mostrarCartel('Registro editado correctamente.','alert-success');
        var table = $('#tableCamas').DataTable();
        table.draw();
        $('#modalEditar').modal('hide');
        },
        error:function(response){
          var errors =  response.responseJSON.errors;
          for (var campo in errors) {
            $("#listaErrores").append('<li type="square">'+errors[campo]+'</li>');
          }       
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
  
  
  
  