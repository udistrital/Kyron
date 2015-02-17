<?php 
//Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
//if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){

?>
        // Asociar el widget de validación al formulario
        $("#registrarInterpretaciones").validationEngine({
            promptPosition : "centerRight", 
            scroll: false
        });
        
        $("#identificacion").attr('disabled','disabled');

        $(function() {
            $("#registrarInterpretaciones").submit(function() {
                $resultado=$("#registrarInterpretaciones").validationEngine("validate");
                
                if ($resultado) {
                
                    return true;
                }
                return false;
            });
        });

                
        $('#fechPresentacion').datepicker({
dateFormat: 'yy-mm-dd',
maxDate: 0,
minDate:'2004-01-01',
changeYear: true,
changeMonth: true,
monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
	'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
	monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
	dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
	dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
	dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'], 
	onSelect: function(dateText, inst) {
var lockDate = new Date($('#fechPresentacion').datepicker('getDate'));
$('input#fechaActa').datepicker('option', 'minDate', lockDate);
}
        
        });
          
          
                  

        $('#fechaActa').datepicker({
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
        $("#entidad").select2();
        $("#docente").select2();
        $("#identificacionFinalConsulta").select2();
        
        
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
        
        
     


