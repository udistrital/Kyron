
$(function() {
	$("#tabs").tabs();
}); 

// Asociar el widget de validación al formulario
$("#indexacionRevista").validationEngine({
	promptPosition : "centerRight", 
    scroll: false,
    autoHidePrompt: true,
    autoHideDelay: 2000
});
	

$(function() {
	$("#indexacionRevista").submit(function() {
    	$resultado=$("#indexacionRevista").validationEngine("validate");
	    if ($resultado) {
	    	return true;
        }
    	return false;
    });
});




$("#<?php echo $this->campoSeguro('docente')?>").select2();
$("#<?php echo $this->campoSeguro('facultad')?>").select2();
$("#<?php echo $this->campoSeguro('proyectoCurricular')?>").select2();
$("#<?php echo $this->campoSeguro('contextoRevista')?>").select2();
$("#<?php echo $this->campoSeguro('docente2')?>").select2();

$('#<?php echo $this->campoSeguro('annoRevista')?>').datepicker({
	closeText: 'Cerrar',
	prevText: '&#x3c;Ant',
	nextText: 'Sig&#x3e;',
	currentText: 'Hoy',
	
	dateFormat: 'yy',
	firstDay: 1,
	isRTL: false,
	/* esto agrege */
	changeYear: true,
	changeMonth: false,
	changeDay: false,
	yearRange: '-50:+0',
	/* hasta aca*/
	showMonthAfterYear: true,
	yearSuffix: '',
	showButtonPanel: true,
});

$('#<?php echo $this->campoSeguro('fechaPublicacionrevista')?>').datepicker({
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
		var lockDate = new Date($('#<?php echo $this->campoSeguro('fechaPublicacionrevista')?>').datepicker('getDate'));
		$('input#<?php echo $this->campoSeguro('fechaPublicacionrevista')?>').datepicker('option', 'minDate', lockDate);
	}, onClose: function() { 
			if ($('input#<?php echo $this->campoSeguro('fechaPublicacionrevista')?>').val()!=''){
                $('#<?php echo $this->campoSeguro('fechaPublicacionrevista')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
            }else {
            	$('#<?php echo $this->campoSeguro('fechaPublicacionrevista')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
            }
		}
});

$('#<?php echo $this->campoSeguro('fechaActaRevista')?>').datepicker({
	dateFormat: 'yy-mm-dd',
	maxDate: 0,
	changeYear: true,
	changeMonth: true,
	changeDay: true,
	monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
	'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
	monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
	dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
	dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
	dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
	onSelect: function(dateText, inst) {
		var lockDate = new Date($('#<?php echo $this->campoSeguro('fechaActaRevista')?>').datepicker('getDate'));
		$('input#<?php echo $this->campoSeguro('fechaActaRevista')?>').datepicker('option', 'minDate', lockDate);
	}, onClose: function() { 
			if ($('input#<?php echo $this->campoSeguro('fechaActaRevista')?>').val()!=''){
                $('#<?php echo $this->campoSeguro('fechaActaRevista')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
            }else {
            	$('#<?php echo $this->campoSeguro('fechaActaRevista')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
            }
		}
});

