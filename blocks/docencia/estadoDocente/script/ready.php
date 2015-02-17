<?php 
//Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){

?>
      
     


       $( "#actualizarDoc" ).ready(function() {
                
              
            switch($("#actualizarDoc").val())
            {
                case '1':
                    $("#cargaDoc").css('display','none');
                    
                break;
            
                case '2':
                    
                   $("#cargaDoc").css('display','block');

                break;
             }
          });
        
            $( "#actualizarDoc" ).change(function() {
            switch($("#actualizarDoc").val())
            {
                case '1':
                    $("#cargaDoc").css('display','none');
                    
                break;
            
                case '2':
                    
                   $("#cargaDoc").css('display','block');

                break;
             }
          }); 


       $('#tablaTitulos').dataTable( {
                "sPaginationType": "full_numbers"
        } );
        
 
  
        
        $(function() {
            $( "input[type=submit], button" )
              .button()
              .click(function( event ) {
                event.preventDefault();
              });
          });
        
    $("#nombreDocumento").attr('disabled','disabled');    
        
	$("#identificacionFinalConsulta").select2();
	$("#facultad").select2();	
	$("#proyecto").select2();
	$("#categoria").select2();
	$("#tiporeporte").select2();
	
	$("#actualizarDoc").select2();
	$("#seleccionEstado").select2();
	$("#seleccionEstadoComplemetario").select2();	

	
	
	  
	
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
		dateFormat: 'yy-mm-dd',
		maxDate: 0,
		changeYear: true,
		changeMonth: true,
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
			'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
			monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
			dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
			dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
			dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'], 
			onSelect: function(dateText, inst) {
		var lockDate = new Date($('#fechaInicioE').datepicker('getDate'));
		$('input#fechaTerminacionE').datepicker('option', 'minDate', lockDate);
		}
		});
	   	
	 	$("#fechaTerminacionE").datepicker({
		dateFormat: 'yy-mm-dd',
		maxDate: 0,
		changeYear: true,
		changeMonth: true,
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
			'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
			monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
			dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
			dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
			dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'], 
			
		}); 	
		
				
				

	//-----------------------------------------------------------------------------------------------------------------
	
	// Asociar el widget de validación al formulario
	
	//
	
 
         $("#estadoDocente").validationEngine({
            promptPosition : "centerRight", 
            scroll: false,
            autoHidePrompt: true,
            autoHideDelay: 2000
	         });
	

         $(function() {
  
            $("#estadoDocente").submit(function() {
                $resultado=$("#estadoDocente").validationEngine("validate");
     
                if ($resultado) {
                
                    return true;
                }
                return false;
                 });

            });



		
	// Asociar el widget para texto enriquecido al campo textarea
	
	$("#observacion").jqte();
	
	// Asociar el widget para selección a los campos tipo select puede generar
	// problemas si no encuentra datos
	
	$("#tipoIdentificacion").select2();
	$("#sedeSolicitante").select2();
	$("#usuarioSolicitante").select2();
	$("#dependenciaSolicitante").select2();	

	
<?php 
}
?>
