<?php 
//Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
//if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){

?>

        var $formValidar = $("#registrarDocente");
        // Asociar el widget de validación al formulario
        $formValidar.validationEngine({
                //validateNonVisibleFields: true,
                promptPosition : "topRight", 
                scroll: false,
                autoHidePrompt: true,
                autoHideDelay: 2000
            }); 
            
            $formValidar.formToWizard({
                submitButton: 'botonGuardarA',
                showProgress: true, 
                nextBtnName: 'Siguiente >>',
                prevBtnName: '<< Anterior',
                showStepNo: true,                
                validateBeforeNext: function() {
                
                    if($("#codigo").val() == '')
                    {
                        alert('Debe validar la información del funcionario para poder continuar');
                        return false;
                    }else
                    {   
                        return $formValidar.validationEngine( 'validate' );
                    }
                    
                }
            });
            
            $formValidar.submit(function() {
                var $resultado=$formValidar.validationEngine("validate");

                if ($resultado) {

                    return true;
                }
                return false;
            });
        
        $("#tipoDocumento").select2();    
        $("#dedicacion").select2();    
        $("#facultad").select2();    
        $("#facultadCrear").select2();    
        $("#proyectoCurricular").select2();    
        $("#categoriaActual").select2();    
            
        
        $('#fechaIngreso').datepicker({
        showOn : 'both',
        buttonImage : 'theme/basico/img/calendar.png',
        buttonImageOnly : true,
        dateFormat: 'yy-mm-dd',
        maxDate: 0,
        changeYear: true,
        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
	'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
	monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
	dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
	dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
	dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa']
        });
	
        
        $('#fechaInicio').datepicker({
        showOn : 'both',
        buttonImage : 'theme/basico/img/calendar.png',
        buttonImageOnly : true,
        dateFormat: 'yy-mm-dd',
        maxDate: 0,
        changeYear: true,
        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
	'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
	monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
	dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
	dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
	dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa']
        });
        
        $('#fechaActa').datepicker({
        showOn : 'both',
        buttonImage : 'theme/basico/img/calendar.png',
        buttonImageOnly : true,
        dateFormat: 'yy-mm-dd',
        maxDate: 0,
        changeYear: true,
        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
	'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
	monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
	dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
	dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
	dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa']
        });
	
        
        
        $("#facultad").select2();
        $("#proyecto").select2();
        $("#categoria").select2();
        
      	
	// Asociar el widget tabs a la división cuyo id es tabs
	$(function() {
		$("#tabs").tabs();
	}); 
        
        $(function() {
            $( "input[type=submit], button" )
              .button()
              .click(function( event ) {
                event.preventDefault();
              });
          });
        
                
        $('#tablaTitulos').dataTable( {
                "sPaginationType": "full_numbers"
        } );  
        
     


