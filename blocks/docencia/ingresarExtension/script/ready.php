<?php 
//Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
//if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){

?>
        // Asociar el widget de validación al formulario
        $("#ingresarExtension").validationEngine({
            promptPosition : "centerRight", 
            scroll: false,
            autoHidePrompt: true,
            autoHideDelay: 2000
        });

        $(function() {
            $("#ingresarExtension").submit(function() {
                $resultado=$("#ingresarExtension").validationEngine("validate");
                
                if ($resultado) {
                
                    return true;
                }
                return false;
            });
        });       
        
        $('#fechaInicio').datepicker({
	    dateFormat: 'yy-mm-dd',
	    maxDate: 0,
	    changeYear: true,
	    monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
		'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
		dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
		dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
		dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
                onSelect: function(dateText, inst) 
                {
                    var lockDate = new Date($('#fechaInicio').datepicker('getDate'));
                    $('input#fechaFinalizacion').datepicker('option', 'minDate', lockDate);
                                        
                    var fecha2 = $('#fechaFinalizacion').datepicker('getDate');
                    var fecha1 = $('#fechaInicio').datepicker('getDate');

                    var diferencia =  Math.floor(( Date.parse(fecha2) - Date.parse(fecha1) ) / 86400000);
                    
                    if(diferencia < 0 || diferencia == 'NaN')
                    {
                        diferencia = "Seleccione fecha inicial y final";
                    }
                    
                    $("#duracion").val(diferencia);
                    
                }
	    });
        
        $('#fechaFinalizacion').datepicker({
        dateFormat: 'yy-mm-dd',
        maxDate: 0,
        changeYear: true,
        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
		'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
		dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
		dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
		dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'], 
                onSelect: function(dateText, inst) 
                {
                    var lockDate = new Date($('#fechaFinalizacion').datepicker('getDate'));
                    $('input#fechaInicio').datepicker('option', 'maxDate', lockDate);
                    
                    var fecha2 = $('#fechaFinalizacion').datepicker('getDate');
                    var fecha1 = $('#fechaInicio').datepicker('getDate');

                    var diferencia =  Math.floor(( Date.parse(fecha2) - Date.parse(fecha1) ) / 86400000);
                    
                    if(diferencia < 0)
                    {
                        diferencia = "Seleccione fecha inicial y final";
                    }
                    
                    $("#duracion").val(diferencia);
                }
        });
    
        
        
        $('#fechaInicio, #fechaFinalizacion').datepicker({onSelect: function(dateStr) 
        {
            var fecha2 = $('#fechaFinalizacion').datepicker('getDate');
            var fecha1 = $('#fechaInicio').datepicker('getDate');
            alert(fecha2);
            alert(fecha1);
            
            var diferencia =  Math.floor(( Date.parse(fecha2) - Date.parse(fecha1) ) / 86400000);
            if(diferencia < 0){
            diferencia = diferencia*(-1);
            }
        
        }
        });
        
        $("#docente").select2();
        $("#docenteConsulta").select2();
        $("#facultad").select2();
        $("#proyecto").select2();
        $("#categoria").select2();
        
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
        
        
     


