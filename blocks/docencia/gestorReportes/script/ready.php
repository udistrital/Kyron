<?php
// Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
// if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){
?>
        // Asociar el widget de validación al formulario
        $("#excelenciaAcademica").validationEngine({
            promptPosition : "centerRight", 
            scroll: false,
            autoHidePrompt: true,
            autoHideDelay: 2000
        });

  $(function() {
            $("#excelenciaAcademica").submit(function() {
                $resultado=$("#excelenciaAcademica").validationEngine("validate");
                
                if ($resultado) {
                
                    return true;
                }
                return false;
            });
        });
   


$('#fechaActa').datepicker({
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



$('#fechaResolucion').datepicker({
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
onSelect: function(dateValue, inst) {
                        $("#fechaActa").datepicker("option", "minDate", dateValue)
                    }


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


$("#facultad").select2();
$("#proyecto").select2();
$("#experiencia").select2();
$("#emiResolucion").select2();
$("#docente").select2();
$("#identificacionFinalConsulta").select2();
$("#identificacion").attr('disabled','disabled');

     $('#tablaTitulos').dataTable( {
                "sPaginationType": "full_numbers"
        } );
        
                       
        $(function() {
		$(document).tooltip();
	});
	
        	$(function() {
		$("#tabs").tabs();
	}); 