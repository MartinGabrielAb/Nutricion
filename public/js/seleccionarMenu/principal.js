$(document).ready( function () {
    //la lista "detalles" la traigo de la vista
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
});

function finalizar(e){
    $("#modalConfirmar").modal('hide');
    $(".divStock").text('');
    $("#spanError").text('');
    e.preventDefault();
    var hayStock = true;
    //detalles = los id de los relevamientocomida
    var data = [];
    detalles.forEach(detalle => {
        let comida = parseInt($("#selectComida"+detalle).val());
        let porciones = parseInt($("#inputRequerida"+detalle).val());     
        let dato = new Array();
        dato.push(detalle);
        dato.push(comida);
        dato.push(porciones);
        data.push(dato);
    });
    $.ajax({
        type:'POST',
        url:"seleccionarMenu",
        dataType:"json",
        data:{
            'data': JSON.stringify(data)
        },
        success: function(response){
            console.log(response.success);
            if(response.success == undefined){
                response.error.forEach( elem => {
                    $("#divStock"+elem).text('Insuficiente');
                });
                $("#spanError").text('Algunas comidas son insuficientes.');
            }else{
                //redirect al historial
            }
          },
        error:function(response){
            console.error("Internal server error");      
        }
      });   
      

}