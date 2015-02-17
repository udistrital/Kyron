<?php 
//Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
//if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){

?>
        // Asociar el widget de validación al formulario
        $("#registrarMovilidadDocente").validationEngine({
            promptPosition : "centerRight", 
            scroll: false,
            autoHidePrompt: true,
            autoHideDelay: 2000
        });

        $(function() {
            $("#registrarMovilidadDocente").submit(function() {
                $resultado=$("#registrarMovilidadDocente").validationEngine("validate");
                
                if ($resultado) {
                
                    return true;
                }
                return false;
            });
        });
        
        //Scripts para ingresar movilidad
        
        $("#docente").select2();
        
        $("#tiquetesDep").select2();
        $("#tiquetesEnt").select2();

        $("#inscripcionDep").select2();
        $("#inscripcionEnt").select2();

        $("#viaticosDep").select2();
        $("#viaticosEnt").select2();
        
        $( "#tiquetesDep" ).change(function() {
            if($("#tiquetesDep").val() != '')
            {
                if($("#tiquetesEnt option[value='']").length == 0)
                {
                    $("#tiquetesEnt").append($('<option>', {value:"", text: "Seleccione..."}));
                }                                
                $("#tiquetesEnt").select2("val", "");
                $("#tiquetesEnt").removeClass( "validate[required]" );
                $("#tiquetesDep").addClass( "validate[required]" );
            }
          });
        $( "#inscripcionDep" ).change(function() {
            if($("#inscripcionDep").val() != '')
            {
                if($("#inscripcionEnt option[value='']").length == 0)
                {
                    $("#inscripcionEnt").append($('<option>', {value:"", text: "Seleccione..."}));
                }
                $("#inscripcionEnt").select2("val", "");
                $("#inscripcionEnt").removeClass( "validate[required]" );
                $("#inscripcionDep").addClass( "validate[required]" );
            }
          });
        $( "#viaticosDep" ).change(function() {
            if($("#viaticosDep").val() != '')
            {
                if($("#viaticosEnt option[value='']").length == 0)
                {
                    $("#viaticosEnt").append($('<option>', {value:"", text: "Seleccione..."}));
                }
                $("#viaticosEnt").select2("val", "");
                $("#viaticosEnt").removeClass( "validate[required]" );
                $("#viaticosDep").addClass( "validate[required]" );
            }
          });
        
        $( "#tiquetesEnt" ).change(function() {
            if($("#tiquetesEnt").val() != '')
            {
                if($("#tiquetesDep option[value='']").length == 0)
                {
                    $("#tiquetesDep").append($('<option>', {value:"", text: "Seleccione..."}));
                }
                $("#tiquetesDep").select2("val", "");
                $("#tiquetesDep").removeClass( "validate[required]" );
                $("#tiquetesEnt").addClass( "validate[required]" );
            }
          });
        $( "#inscripcionEnt" ).change(function() {
            if($("#inscripcionEnt").val() != '')
            {
                if($("#inscripcionDep option[value='']").length == 0)
                {
                    $("#inscripcionDep").append($('<option>', {value:"", text: "Seleccione..."}));
                }
                $("#inscripcionDep").select2("val", "");
                $("#inscripcionDep").removeClass( "validate[required]" );
                $("#inscripcionEnt").addClass( "validate[required]" );
            }
          });
        $( "#viaticosEnt" ).change(function() {
            if($("#viaticosEnt").val() != '')
            {
                if($("#viaticosDep option[value='']").length == 0)
                {
                    $("#viaticosDep").append($('<option>', {value:"", text: "Seleccione..."}));
                }
                $("#viaticosDep").select2("val", "");
                $("#viaticosDep").removeClass( "validate[required]" );
                $("#viaticosEnt").addClass( "validate[required]" );
            }
          });
        
          
          // Scripts para consulta de movilidad
          
          $("#docenteConsulta").select2();
          $("#facultad").select2();
          $("#proyecto").select2();
        
        
        $('#tablaTitulos').dataTable( {
                "sPaginationType": "full_numbers"
        } );
        
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
        
        
     


