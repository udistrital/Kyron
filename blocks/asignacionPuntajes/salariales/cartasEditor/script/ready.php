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
$('#<?php echo $this->campoSeguro('annoRevista')?>').width(450);


///*********El ancho (width) de los siguientes campos es mayor debido a que se encuentran dentro de un div****///
$('#<?php echo $this->campoSeguro('pais')?>').width(470);
$('#<?php echo $this->campoSeguro('categoria')?>').width(470);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//////////////////**********Se definen los campos que requieren campos de autocompletar**********////////////////

$("#<?php echo $this->campoSeguro('facultad')?>").select2();
$("#<?php echo $this->campoSeguro('proyectoCurricular')?>").select2();

$("#<?php echo $this->campoSeguro('contextoRevista')?>").select2();
$("#<?php echo $this->campoSeguro('annoRevista')?>").select2();

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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

var puntaje = $("#<?php echo $this->campoSeguro('puntajeRevista')?>" ).val();

$( "#<?php echo $this->campoSeguro('puntajeRevista')?>" ).keyup(function() {
	if(!isNaN($( "#<?php echo $this->campoSeguro('puntajeRevista')?>" ).val())){
			puntaje = $( "#<?php echo $this->campoSeguro('puntajeRevista')?>" ).val();
			$('#<?php echo $this->campoSeguro('puntajeRevista') ?>').val(puntaje);
	}else{
		$('#<?php echo $this->campoSeguro('puntajeRevista') ?>').val(puntaje);
	}
	
});

var numeroCasoActaRevista = $("#<?php echo $this->campoSeguro('numeroCasoActaRevista')?>" ).val();

$( "#<?php echo $this->campoSeguro('numeroCasoActaRevista')?>" ).keyup(function() {
	if(!isNaN($( "#<?php echo $this->campoSeguro('numeroCasoActaRevista')?>" ).val())){
			numeroCasoActaRevista = $( "#<?php echo $this->campoSeguro('numeroCasoActaRevista')?>" ).val();
			$('#<?php echo $this->campoSeguro('numeroCasoActaRevista') ?>').val(numeroCasoActaRevista);
	}else{
		$('#<?php echo $this->campoSeguro('numeroCasoActaRevista') ?>').val(numeroCasoActaRevista);
	}
	
});

var numeroAutoresUniversidad = $("#<?php echo $this->campoSeguro('numeroAutoresUniversidad')?>" ).val();

$( "#<?php echo $this->campoSeguro('numeroAutoresUniversidad')?>" ).keyup(function() {
	if(!isNaN($( "#<?php echo $this->campoSeguro('numeroAutoresUniversidad')?>" ).val())){
			numeroAutoresUniversidad = $( "#<?php echo $this->campoSeguro('numeroAutoresUniversidad')?>" ).val();
			$('#<?php echo $this->campoSeguro('numeroAutoresUniversidad') ?>').val(numeroAutoresUniversidad);
	}else{
		$('#<?php echo $this->campoSeguro('numeroAutoresUniversidad') ?>').val(numeroAutoresUniversidad);
	}
	
});

var numeroAutoresRevista = $("#<?php echo $this->campoSeguro('numeroAutoresRevista')?>" ).val();

$( "#<?php echo $this->campoSeguro('numeroAutoresRevista')?>" ).keyup(function() {
	if(!isNaN($( "#<?php echo $this->campoSeguro('numeroAutoresRevista')?>" ).val())){
			numeroAutoresRevista = $( "#<?php echo $this->campoSeguro('numeroAutoresRevista')?>" ).val();
			$('#<?php echo $this->campoSeguro('numeroAutoresRevista') ?>').val(numeroAutoresRevista);
	}else{
		$('#<?php echo $this->campoSeguro('numeroAutoresRevista') ?>').val(numeroAutoresRevista);
	}
	
});

var paginasRevista = $("#<?php echo $this->campoSeguro('paginasRevista')?>" ).val();

$( "#<?php echo $this->campoSeguro('paginasRevista')?>" ).keyup(function() {
	if(!isNaN($( "#<?php echo $this->campoSeguro('paginasRevista')?>" ).val())){
			paginasRevista = $( "#<?php echo $this->campoSeguro('paginasRevista')?>" ).val();
			$('#<?php echo $this->campoSeguro('paginasRevista') ?>').val(paginasRevista);
	}else{
		$('#<?php echo $this->campoSeguro('paginasRevista') ?>').val(paginasRevista);
	}
	
});


var numeroRevista = $("#<?php echo $this->campoSeguro('numeroRevista')?>" ).val();

$( "#<?php echo $this->campoSeguro('numeroRevista')?>" ).keyup(function() {
	if(!isNaN($( "#<?php echo $this->campoSeguro('numeroRevista')?>" ).val())){
			numeroRevista = $( "#<?php echo $this->campoSeguro('numeroRevista')?>" ).val();
			$('#<?php echo $this->campoSeguro('numeroRevista') ?>').val(numeroRevista);
	}else{
		$('#<?php echo $this->campoSeguro('numeroRevista') ?>').val(numeroRevista);
	}
	
});


var volumenRevista = $("#<?php echo $this->campoSeguro('volumenRevista')?>" ).val();

$( "#<?php echo $this->campoSeguro('volumenRevista')?>" ).keyup(function() {
	if(!isNaN($( "#<?php echo $this->campoSeguro('volumenRevista')?>" ).val())){
			volumenRevista = $( "#<?php echo $this->campoSeguro('volumenRevista')?>" ).val();
			$('#<?php echo $this->campoSeguro('volumenRevista') ?>').val(volumenRevista);
	}else{
		$('#<?php echo $this->campoSeguro('volumenRevista') ?>').val(volumenRevista);
	}
	
});

