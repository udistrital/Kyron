
// Asociar el widget de validación al formulario
$("#radicarAsignar").validationEngine({
promptPosition : "centerRight", 
scroll: false,
autoHidePrompt: true,
autoHideDelay: 2000
});


$(function() {
$("#radicarAsignar").submit(function() {
$resultado=$("#radicarAsignar").validationEngine("validate");

if ($resultado) {

return true;
}
return false;
});
});


        $(function() {
		$(document).tooltip();
	});
	
        	$(function() {
		$("#tabs").tabs();
	}); 

                     $('#tablaTitulos').dataTable( {
                "sPaginationType": "full_numbers"
                 } );
                 
                     $('#<?php echo $this->campoSeguro('fecha_inicio')?>').datepicker({
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
			var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_inicio')?>').datepicker('getDate'));
			$('input#<?php echo $this->campoSeguro('fecha_final')?>').datepicker('option', 'minDate', lockDate);
			},
			onClose: function() { 
		 	    if ($('input#<?php echo $this->campoSeguro('fecha_inicio')?>').val()!='')
                    {
                        $('#<?php echo $this->campoSeguro('fecha_final')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
                }else {
                        $('#<?php echo $this->campoSeguro('fecha_final')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
                    }
			  }
			
			
		});
              $('#<?php echo $this->campoSeguro('fecha_final')?>').datepicker({
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
			var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_final')?>').datepicker('getDate'));
			$('input#<?php echo $this->campoSeguro('fecha_inicio')?>').datepicker('option', 'maxDate', lockDate);
			 },
			 onClose: function() { 
		 	    if ($('input#<?php echo $this->campoSeguro('fecha_final')?>').val()!='')
                    {
                        $('#<?php echo $this->campoSeguro('fecha_inicio')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
                }else {
                        $('#<?php echo $this->campoSeguro('fecha_inicio')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
                    }
			  }
			
	   });
	   
                 

$("#<?php echo $this->campoSeguro('tipoCargue') ?>").select2();
$("#<?php echo $this->campoSeguro('numero_entrada') ?>").select2();
$("#<?php echo $this->campoSeguro('vigencia_entrada') ?>").select2();

$("#<?php echo $this->campoSeguro('tipoDocumento') ?>").select2();
$("#<?php echo $this->campoSeguro('tipoContrato') ?>").select2();




$("#<?php echo $this->campoSeguro('tipoCargueConsulta') ?>").select2();
$("#<?php echo $this->campoSeguro('numero_entradaConsulta') ?>").select2();
$("#<?php echo $this->campoSeguro('tipoDocumentoConsulta') ?>").select2();


$('#<?php echo $this->campoSeguro('tipoContrato')?>').attr('disabled','');




$( "#<?php echo $this->campoSeguro('tipoCargue')?>" ).change(function() {
switch($("#<?php echo $this->campoSeguro('tipoCargue') ?>").val())
{

case '1':
$('#<?php echo $this->campoSeguro('tipoContrato')?>').removeAttr('disabled');
$("#<?php echo $this->campoSeguro('tipoContrato') ?>").select2();
break;


case '5':

$('#<?php echo $this->campoSeguro('tipoContrato')?>').removeAttr('disabled');
$("#<?php echo $this->campoSeguro('tipoContrato') ?>").select2();
break;


case '6':

$('#<?php echo $this->campoSeguro('tipoContrato')?>').removeAttr('disabled');
$("#<?php echo $this->campoSeguro('tipoContrato') ?>").select2();
break;


case '7':

$('#<?php echo $this->campoSeguro('tipoContrato')?>').removeAttr('disabled');
$("#<?php echo $this->campoSeguro('tipoContrato') ?>").select2();
break;

default:

$('#<?php echo $this->campoSeguro('tipoContrato')?>').attr('disabled','');
break;

}
});  








