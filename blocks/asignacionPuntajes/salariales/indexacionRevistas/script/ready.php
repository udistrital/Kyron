$("#indexacionRevistas").validationEngine({
promptPosition : "centerRight", 
scroll: false,
autoHidePrompt: true,
autoHideDelay: 2000
});

$(function() {
	$("#indexacionRevistas").submit(function() {
		$resultado=$("#indexacionRevistas").validationEngine("validate");
		if ($resultado) {
			return true;
		}
		return false;
	});
});

$("#indexacionRevistasRegistrar").validationEngine({
	promptPosition : "centerRight", 
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});

$(function() {
$("#indexacionRevistasRegistrar").submit(function() {
$resultado=$("#indexacionRevistasRegistrar").validationEngine("validate");

if ($resultado) {

return true;
}
return false;
});
});

$(function () {
    $("button").button().click(function (event) {
        event.preventDefault();
    });
});

$(function() {
	$("#indexacionRevistasModificar").submit(function() {
		$resultado=$("#indexacionRevistasModificar").validationEngine("validate");
		if ($resultado) {
			return true;
		}
		return false;
	});
});

$("#indexacionRevistasModificar").validationEngine({
	promptPosition : "centerRight", 
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});

$('#tablaTitulos').dataTable( {
	"sPaginationType": "full_numbers"
});
        
////////////Función que organiza los tabs en la interfaz gráfica//////////////
$(function() {
	$("#tabs").tabs();
}); 
//////////////////////////////////////////////////////////////////////////////

// Asociar el widget de validación al formulario


/////////Se define el ancho de los campos de listas desplegables///////

$('#<?php echo $this->campoSeguro('docente')?>').width(465);      
$('#<?php echo $this->campoSeguro('facultad')?>').width(450);      
$('#<?php echo $this->campoSeguro('proyectoCurricular')?>').width(450);      

$('#<?php echo $this->campoSeguro('docenteRegistrar')?>').width(465);
$('#<?php echo $this->campoSeguro('contextoRevista')?>').width(450);


///*********El ancho (width) de los siguientes campos es mayor debido a que se encuentran dentro de un div****///
$('#<?php echo $this->campoSeguro('pais')?>').width(470);
$('#<?php echo $this->campoSeguro('categoria')?>').width(470);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//////////////////**********Se definen los campos que requieren campos de autocompletar**********////////////////

$("#<?php echo $this->campoSeguro('facultad')?>").select2();
$("#<?php echo $this->campoSeguro('proyectoCurricular')?>").select2();

$("#<?php echo $this->campoSeguro('contextoRevista')?>").select2();

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////


           	 
              	 

//////********Esta sección del código permite ocultar los dias del menú del datePicker.*********//////

$( "#<?php echo $this->campoSeguro('annoRevista')?>" ).click(function() {
	$(".ui-datepicker-calendar").hide();
	$(".ui-datepicker-prev").hide();
	$(".ui-datepicker-next").hide();
	$(".ui-datepicker-month").hide();
	$(".ui-datepicker-year").change(function() {
		$( "#<?php echo $this->campoSeguro('annoRevista')?>" ).val($(".ui-datepicker-year").val());
		$( "#ui-datepicker-div" ).hide();
		$( "#<?php echo $this->campoSeguro('annoRevista')?>" ).datepicker("hide");
		$( "#<?php echo $this->campoSeguro('annoRevista')?>" ).blur();		
	});
	$(".ui-datepicker-current").click(function() {
		$( "#<?php echo $this->campoSeguro('annoRevista')?>" ).val($(".ui-datepicker-year").val());
		$( "#ui-datepicker-div" ).hide();
		$( "#<?php echo $this->campoSeguro('annoRevista')?>" ).datepicker("hide");
		$( "#<?php echo $this->campoSeguro('annoRevista')?>" ).blur();	
	});
});

////////////////////////////////////////////////////////////////////////////////////////////////////////


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
	showButtonPanel: true
});

$('#<?php echo $this->campoSeguro('fechaPublicacionrevista')?>').datepicker({
	dateFormat: 'yy-mm-dd',
	maxDate: -1,
	yearRange: '-50:+0',
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
	maxDate: -1,
	yearRange: '-50:+0',
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

