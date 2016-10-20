$("#produccionDeVideos").validationEngine({
promptPosition : "bottomRight:-150", 
scroll: false,
autoHidePrompt: true,
autoHideDelay: 2000
});

$(function() {
	$("#produccionDeVideos").submit(function() {
		$resultado=$("#produccionDeVideos").validationEngine("validate");
		if ($resultado) {
			return true;
		}
		return false;
	});
});

$("#produccionDeVideosRegistrar").validationEngine({
	promptPosition : "bottomRight:-150", 
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});

$(function() {
$("#produccionDeVideosRegistrar").submit(function() {
$resultado=$("#produccionDeVideosRegistrar").validationEngine("validate");

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
	$("#produccionDeVideosModificar").submit(function() {
		$resultado=$("#produccionDeVideosModificar").validationEngine("validate");
		if ($resultado) {
			return true;
		}
		return false;
	});
});

$("#produccionDeVideosModificar").validationEngine({
	promptPosition : "bottomRight:-150", 
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
$('#<?php echo $this->campoSeguro('impacto')?>').width(450);
$('#<?php echo $this->campoSeguro('caracter')?>').width(450);

$('#<?php echo $this->campoSeguro('universidadEvaluador2')?>').width(450);
$('#<?php echo $this->campoSeguro('universidadEvaluador1')?>').width(450);
$('#<?php echo $this->campoSeguro('universidadEvaluador3')?>').width(465);


//////////////////**********Se definen los campos que requieren campos de select2**********////////////////

$("#<?php echo $this->campoSeguro('facultad')?>").select2();
$("#<?php echo $this->campoSeguro('proyectoCurricular')?>").select2();

$("#<?php echo $this->campoSeguro('impacto')?>").select2();
$("#<?php echo $this->campoSeguro('caracter')?>").select2();

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*
 * Se asigna dinámicamente el parámetro required a los select2. Se quita un reminicente de:
 */ 
var obj = $("#<?php echo $this->campoSeguro('universidadEvaluador1')?>").select2();
if(obj.length>0){
	var clases = obj.attr('class').split(' ');
	var claseValidate = $.grep(clases,function(v,i){return v.indexOf('validate')>-1})[0];
	obj.removeClass(claseValidate);
	claseValidate = claseValidate.insertAt(claseValidate.indexOf("[")+1,'required,');
	obj.addClass(claseValidate);
}

var obj = $("#<?php echo $this->campoSeguro('universidadEvaluador2')?>").select2();
if(obj.length>0){
	var clases = obj.attr('class').split(' ');
	var claseValidate = $.grep(clases,function(v,i){return v.indexOf('validate')>-1})[0];
	obj.removeClass(claseValidate);
	claseValidate = claseValidate.insertAt(claseValidate.indexOf("[")+1,'required,');
	obj.addClass(claseValidate);
}

var obj = $("#<?php echo $this->campoSeguro('universidadEvaluador3')?>").select2();
if(obj.length>0){
	var clases = obj.attr('class').split(' ');
	var claseValidate = $.grep(clases,function(v,i){return v.indexOf('validate')>-1})[0];
	obj.removeClass(claseValidate);
	claseValidate = claseValidate.insertAt(claseValidate.indexOf("[")+1,'required,');
	obj.addClass(claseValidate);
}

/*Se limpia el campo de doncente a consultar o a registrar cuando no se realiza
una elección del listado desplegado*/

$("#<?php echo $this->campoSeguro('docente')?>").blur(function() {
 	$("#<?php echo $this->campoSeguro('docente')?>").val("");
});

$("#<?php echo $this->campoSeguro('docenteRegistrar')?>").blur(function() {
 	$("#<?php echo $this->campoSeguro('docenteRegistrar')?>").val("");
});
