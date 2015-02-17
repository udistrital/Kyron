<?php
// Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
// if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){
?>
        // Asociar el widget de validación al formulario
        $("#ingresarConvenios").validationEngine({
            promptPosition : "centerRight", 
            scroll: false,
            autoHidePrompt: true,
            autoHideDelay: 2000
        });

        $(function() {
            $("#ingresarConvenios").submit(function() {
                $resultado=$("#ingresarConvenios").validationEngine("validate");
                
                if ($resultado) {
                
                    return true;
                }
                return false;
            });
        });


        $("#docente").select2();
        $("#identificacionFinalConsulta").select2();
        $("#facultad").select2();
        $("#proyecto").select2();
        $("#rol_docente").select2();
        $("#actualizarDoc").select2();
        
        
        
        
        
                // Validacion para el numero de autores
          
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
          
          
                $( "#actualizarDoc" ).ready(function() {
                
                $("#nom_documento").attr('disabled','disabled');
                $("#identificacion").attr('disabled','disabled');
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
		$(document).tooltip();
	});
	
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
        
        
     


