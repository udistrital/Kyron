<?php 
//Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
//if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){

?>
        // Asociar el widget de validación al formulario
        $("#docentesconcarga").validationEngine({
            promptPosition : "centerRight", 
            scroll: false
        });

        $(function() {
            $("#docentesconcarga").submit(function() {
                $resultado=$("#docentesconcarga").validationEngine("validate");
                
                if ($resultado) {
                
                    return true;
                }
                return false;
            });
        });

        $("#periodo").select2();
        $("#proyecto").select2();
        $("#facultad").select2();
        $("#tipo_vinculacion").select2();
        $("#tipo_nivel").select2();
        
        $('#tablaProcesos').dataTable( {
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
        
        
     


