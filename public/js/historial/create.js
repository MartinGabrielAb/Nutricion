$(document).ready( function () {
	var cantParticulares = $('#cantParticulares').val();
	$('#selectGeneral').select2({
	        width: 'resolve',
	        theme: "classic",
	        placeholder: "Buscar menú",
	        allowClear: true
	      });

	$('.selectParticulares').select2({
	        width: 'resolve',
	        theme: "classic",
	        placeholder: "Buscar menú particular",
	        allowClear: true
	      });

	$("#selectGeneral").change(function(){
        var idMenuGeneral = $(this).val();
	});

	$(".selectParticulares").change(function(){
        var idPacienteParticular = $(this).data('id');
        var idMenuParticular = $(this).val();

	});

	$("#btnSeleccionar").click(function(){
		var relevamientoId = parseInt($('#relevamientoId').html());
        var menuGeneralId = $('#selectGeneral').val();
        var camposLlenos  = true;
		var particulares = [];
		if (menuGeneralId == '') {
			camposLlenos = false;
		}
		$('.selectParticulares').each(function(index, elem){		
			if($(this).val() == ''){
				camposLlenos = false;
			}else{
				let particular = {
					pacienteId : parseInt($(this).data('id')),
					menuParticularId : parseInt($(this).val())
				}
				particulares.push(particular);
			}
		});
		if(particulares.length<1){
			particulares = null;
		}
        if (camposLlenos == true) {
        	$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
	        });
	        $.ajax({
	          	type:'POST',
	            url:"/historial",
	            dataType:"json",
	            data:{
						relevamientoId: relevamientoId,
						menuGeneralId: menuGeneralId,
	                    particulares: particulares,
	                },
	         success: function(response) {
				if(response.success == "true"){
					$('#divMensaje').text(response.message);
					window.location.href = "../../historial/"+response.historialId;
				}else{
					$('#divMensaje').text(response.message);
				}
	          },
	          error:function(){
	            $("#labelComprobar").text("ERROR 1");
	            devolver = false;
	          }
	        });
	    }else{
	    	$('#divMensaje').text("Debe seleccionar todos los menúes");
	    }
        
      });
	
});
