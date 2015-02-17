<?php 
//Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
//if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){

?>
        // Asociar el widget de validación al formulario
        $("#registrarTraducciones").validationEngine({
            promptPosition : "centerRight", 
            scroll: false
        });

        $(function() {
            $("#registrarTraducciones").submit(function() {
                $resultado=$("#registrarTraducciones").validationEngine("validate");
                
                if ($resultado) {
                
                    return true;
                }
                return false;
            });
        });       
             

        
        $('#fechaTraduccion').datepicker({
dateFormat: 'yy-mm-dd',
maxDate: 0,
changeYear: true,
monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
	'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
	monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
	dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
	dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
	dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
onSelect: function(dateText, inst) {
var lockDate = new Date($('#fechaTraduccion').datepicker('getDate'));
//lockDate.setDate(lockDate.getDate() + 1);
$('input#fechaActa').datepicker('option', 'minDate', lockDate);
$('input#yearLibro').datepicker('option', 'minDate', lockDate);

}
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
	onSelect: function(dateText, inst) {
var lockDate = new Date($('#fechaActa').datepicker('getDate'));
//lockDate.setDate(lockDate.getDate() + 1);
$('input#fechaTraduccion').datepicker('option', 'maxDate', lockDate);
$('input#yearLibro').datepicker('option', 'maxDate', lockDate);
}
});
        
        
        
        
          $('#yearLibro').datepicker( {   
    	changeYear: true,
    	minDate:  $('#fechaTraduccion').datepicker('getDate'),
    	maxDate: 0,
    	monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
	'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
   		 showButtonPanel: true,
    	dateFormat: 'yy',
    	onClose: function(dateText, inst) {
    	//lockDate.setDate(lockDate.getDate() + 1);
        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
        $(this).datepicker('setDate', new Date(year, 1, 1));
        var strDate ="01/01"+"/"+year;
      		}      			
      	     		
		});
		
		$("#yearLibro").focus(function () {
    	$(".ui-datepicker-calendar").hide();
    	$("#ui-datepicker-div").position({
        my: "center top",
        at: "center bottom",
        of: $(this)
    		});
		});
        
                
                

        
        $("#facultad").select2();
        $("#proyecto").select2();
        $("#docente").select2();
        $("#identificacionFinalConsulta").select2();
        
        $('#tablaTraduccion').dataTable( {
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
        
        
     


