$("#produccionDeLibros").validationEngine({
	promptPosition : "centerRight", 
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});

$("#produccionDeLibros").submit(function() {
	$resultado=$("#produccionDeLibros").validationEngine("validate");
	if ($resultado) {
		return true;
	}
	return false;
});

$("#produccionDeLibrosRegistrar").validationEngine({
	promptPosition : "centerRight", 
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});

$("#produccionDeLibrosRegistrar").submit(function() {
	$resultado=$("#produccionDeLibrosRegistrar").validationEngine("validate");		
	if ($resultado) {
		return true;
	}
	return false;
});

$("button").button().click(function (event) { 
    event.preventDefault();
});

$("#produccionDeLibrosModificar").submit(function() {
	$resultado=$("#produccionDeLibrosModificar").validationEngine("validate");
	if ($resultado) {
		return true;
	}
	return false;
});

$("#produccionDeLibrosModificar").validationEngine({
	promptPosition : "centerRight", 
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});

$('#tablaTitulos').dataTable( {
	"sPaginationType": "full_numbers"
});
        
/*
 * Función que organiza los tabs en la interfaz gráfica
 */
$(function() {
	$("#tabs").tabs();
}); 

/*
 * Asociar el widget de validación al formulario
 */

/*
 * Se define el ancho de los campos de listas desplegables
 */

$('#<?php echo $this->campoSeguro('docente')?>').width(465);      
$('#<?php echo $this->campoSeguro('facultad')?>').width(450);      
$('#<?php echo $this->campoSeguro('proyectoCurricular')?>').width(450);      

$('#<?php echo $this->campoSeguro('docenteRegistrar')?>').width(465);
$('#<?php echo $this->campoSeguro('tipoLibro')?>').width(450);
$('#<?php echo $this->campoSeguro('annoLibro')?>').width(450);

$('#<?php echo $this->campoSeguro('editorial')?>').width(450);

$('#<?php echo $this->campoSeguro('entidadCertificadora1')?>').width(300);
$('#<?php echo $this->campoSeguro('entidadCertificadora2')?>').width(300);
$('#<?php echo $this->campoSeguro('entidadCertificadora3')?>').width(300);


/*
 * Se definen los campos que requieren campos de Select2
 */
$("#<?php echo $this->campoSeguro('facultad')?>").select2();
$("#<?php echo $this->campoSeguro('proyectoCurricular')?>").select2();


$("#<?php echo $this->campoSeguro('tipoLibro')?>").select2();
$("#<?php echo $this->campoSeguro('annoLibro')?>").select2();
$("#<?php echo $this->campoSeguro('editorial')?>").select2();

/*
 * Se asigna dinámicamente el parámetro required a los select2. Se quita un reminicente de:
 */
var obj = $("#<?php echo $this->campoSeguro('entidadCertificadora1')?>").select2();
var clases = obj.attr('class').split(' ');
var claseValidate = $.grep(clases,function(v,i){return v.indexOf('validate')>-1})[0];
obj.removeClass(claseValidate);
claseValidate = claseValidate.insertAt(claseValidate.indexOf("[")+1,'required,');
obj.addClass(claseValidate);

var obj = $("#<?php echo $this->campoSeguro('entidadCertificadora2')?>").select2();
var clases = obj.attr('class').split(' ');
var claseValidate = $.grep(clases,function(v,i){return v.indexOf('validate')>-1})[0];
obj.removeClass(claseValidate);
claseValidate = claseValidate.insertAt(claseValidate.indexOf("[")+1,'required,');
obj.addClass(claseValidate);

var obj = $("#<?php echo $this->campoSeguro('entidadCertificadora3')?>").select2();
var clases = obj.attr('class').split(' ');
var claseValidate = $.grep(clases,function(v,i){return v.indexOf('validate')>-1})[0];
obj.removeClass(claseValidate);
claseValidate = claseValidate.insertAt(claseValidate.indexOf("[")+1,'required,');
obj.addClass(claseValidate);
