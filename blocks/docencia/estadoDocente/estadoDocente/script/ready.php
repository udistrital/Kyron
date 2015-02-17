<?php 
//Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){

?>
	
	
	
	 $('#mostrarDocente1').attr('disabled','');
     
     $('#mostrarDocente2').attr('disabled','');
     
     $('#mostrarDocente3').attr('disabled','');
     
     $('#mostrarDocente4').attr('disabled','');
     
    $("#seleccion").change(function() {
				resetFormulario();
				filtrar();
				
		});
		
		
	   $("#seleccionEstado").change(function() {
				 if(  $('#seleccionEstado').val()=='1'){
				 
				 $("#ParametrosEstado").css('display','block');
				 
				  }else{
				  
				  
				  $("#ParametrosEstado").css('display','none');
				  
				  }
		});
				
			   $("#botonExcel").click(function() {
		
				 
				 $("#botonPDF").val()='false';
				 
				 
				  
				  
	
				});
		
	
	

     $("#docentesTodos").change(function() {
		if($("#docentesTodos").is(':checked')){		
	   $('#selecciondocente4').attr('disabled',''); 
	   $('#botonModificarA').attr('disabled','True'); 		 
			}else{
			
	   $('#selecciondocente4').removeAttr('disabled'); 
       $('#botonModificarA').removeAttr('disabled');  
			} 
				 
		});		
	   	
    
    
    
    
    $("#numeroIdentificacion").keyup(function() {
				consultarNunCedula();
		});
		
		
		
    $("#seleccioncategoria").change(function() {
				 consultarCategoria();
		});
		
	 $("#seleccionfacultad").change(function() {
				 consultarfacultad();
		});	
		
	 $("#seleccionProyectoCurricular").change(function() {
				 consultarProyectoCurricular();
		});
		
		
		
     $("#seleccioncategoriaT").change(function() {
				 filtrarGeneral();
		});
		
	 $("#seleccionfacultadT").change(function() {
				 filtrarGeneral();
		});	
		
	 $("#seleccionProyectoCurricularT").change(function() {
				 filtrarGeneral();
		});		
	  
	 	$("#fechaInicioE").datepicker({
		showOn : 'both',
		buttonImage : 'theme/basico/img/calendar.png',
		buttonImageOnly : true,
		changeYear : true,
		
	}); 
	   	
	 	$("#fechaTerminacionE").datepicker({
		showOn : 'both',
		buttonImage : 'theme/basico/img/calendar.png',
		buttonImageOnly : true,
		changeYear : true,
		
	}); 	
		
				
				

	//-----------------------------------------------------------------------------------------------------------------
	
	// Asociar el widget de validación al formulario
	
	//
	$("#registrarDocente").validationEngine({
	    promptPosition : "centerRight", 
	    scroll: false
	});

	$(function() {
	    $("#registrarDocente").submit(function() {
	        $resultado=$("#registrarDocente").validationEngine("validate");
	        if ($resultado) {
	            // console.log(filasGrilla);
	            return true;
	        }
	        return false;
	    });
	});

	$("#fechaNacimiento").datepicker({
		showOn : 'both',
		buttonImage : 'theme/basico/img/calendar.png',
		buttonImageOnly : true,
		changeYear : true,
		
	});
	$("#fechaIngreso").datepicker({
		showOn : 'both',
		buttonImage : 'theme/basico/img/calendar.png',
		buttonImageOnly : true,
		changeYear : true,
		
	});
	
	$("#fechaInicioAño").datepicker({
		showOn : 'both',
		buttonImage : 'theme/basico/img/calendar.png',
		buttonImageOnly : true,
		changeYear : true,
		
	});
	
	$("#fechaActa").datepicker({
		showOn : 'both',
		buttonImage : 'theme/basico/img/calendar.png',
		buttonImageOnly : true,
		changeYear : true,
		
	});
	
		
	$(function() {
    $( "button" )
    .button()
    .click(function( event ) {
        event.preventDefault();
    	});
	});


	$(function() {
	    $( document ).tooltip();
	});
		
	// Asociar el widget para texto enriquecido al campo textarea
	
	$("#observacion").jqte();
	
	// Asociar el widget para selección a los campos tipo select puede generar
	// problemas si no encuentra datos
	
	$("#tipoIdentificacion").select2();
	$("#sedeSolicitante").select2();
	$("#usuarioSolicitante").select2();
	$("#dependenciaSolicitante").select2();	
<!-- 	$("#cargoSolicitante").keydown(function(event){ -->
<!--     if((event.keyCode < 46 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105) && (event.keyCode!=8) && (event.keyCode!=9) && (event.keyCode < 37 || event.keyCode > 40)){ -->
<!--    return false; -->
<!--        } -->
<!--     }); -->
	
<?php 
}
?>
