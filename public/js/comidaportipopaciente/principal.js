jQuery( function () {
    var detalleMenuTipoPacienteId = $("#detalleMenuTipoPacienteId").val();
    var table = $('#tableComidas').DataTable({
      responsive: true,
      "serverSide":true,
      "ajax": "../menuportipopaciente/"+detalleMenuTipoPacienteId,
        rowId: "ComidaPorTipoPacienteId",
      "columns": [
        {data: "TipoComidaNombre"},
        {data: "ComidaNombre"},
        {data: 'Variante'},
        {data:'btn',orderable:false,sercheable:false},
      ],
      "language": { "url": "../JSON/Spanish_dataTables.json"},
    });
  
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
 
   
    
    /*------Funcion para llenar los campos cuando selecciono una fila -----*/ 
  $("#tipoComida").on('change',function(){
      $("#comida").empty();
      $.ajax({
          type:'GET',
          url:"../comidas/"+$('#tipoComida').val()+"/edit",
          dataType:"json",
          beforeSend:function(){
              $("#mensaje").show().text("Cargando..");
          },
          success: function(response){
              if(response[0]==undefined){
                  $("#mensaje").text("No hay comidas de este tipo cargadas.");
                  $("#comida").val("");
                  $("#divComida").hide();
                  return;
              }
              $("#mensaje").hide();
              for (var campo in response) {
                  $("#comida").append("<option value='"+response[campo]['ComidaId']+"'>"+response[campo]['ComidaNombre']+ "</option>");
                } 
              $("#divComida").show();
  
              
          },
          error:function(response){
            var errors =  response.responseJSON.errors;
            for (var campo in errors) {
              $("#listaErrores").append('<li type="square">'+errors[campo]+'</li>');
            }       
          }
        });
      });      
  });
  
  
  function vaciarCampos(){
    $("#tipoPaciente").val("");
    $("#listaErrores").empty();
    $('input:radio[name=variante][value=1]').click();
  };
  
  function agregar(){
    
    $("#tipoComida").val("");
    $("#divComida").hide();
    $("#divMensaje").hide();
    $("#mensaje").val("");
    $("#comida").val("");
    vaciarCampos();
    $("#tituloModal").text("Agregar comida");
    $("#btnGuardar span").text("Guardar");
  }
 
  function mostrarCartel(texto,clase){
    $('#divMensaje').removeClass('alert-success alert-danger');
    $('#divMensaje').fadeIn();
    $('#divMensaje').text(texto);
    $('#divMensaje').addClass(clase);  
    $('#divMensaje').fadeOut(4000);
  }
  
 
  function guardar(e){
    $("#listaErrores").empty();
    e.preventDefault();
      $.ajax({
        type:'POST',
        url:"../comidaportipopaciente",
        dataType:"json",
        data:{
            detalleMenuTipoPacienteId: $('#detalleMenuTipoPacienteId').val(),
            tipocomida: $('#tipoComida').val(),
            comida: $('#comida').val(),
            variante:$('input[name="variante"]:checked').val(),//1 Predeterminado - 0 Opcional
        },
        success: function(response){
          $('#modal').modal('hide');
          mostrarCartel('Registro agregado correctamente.','alert-success');
          var table = $('#tableComidas').DataTable();
          table.draw();
          },
        error:function(response){
          var errors =  response.responseJSON.errors;
          console.log(errors);
          for (var campo in errors) {
            $("#listaErrores").append('<li type="square">'+errors[campo][0]+'</li>');
          }       
        }
      });

  }
 
       
  function eliminar(id){
    $.ajax({
      type:"DELETE",
      url: "../comidaportipopaciente/"+id,
      data: {
        "_method": 'DELETE',
        "id": id
      },
      success: function(response) {
        mostrarCartel('Registro eliminado correctamente.','alert-success');
        var table = $('#tableComidas').DataTable();
        table.row('#'+id).remove().draw();
      },
      error:function(){
        mostrarCartel('Error al eliminar el registro.','alert-danger');
      }
    });
  }

  