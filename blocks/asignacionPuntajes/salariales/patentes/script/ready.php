$("#patentes").validationEngine({
promptPosition : "bottomRight:-150", 
scroll: false,
autoHidePrompt: true,
autoHideDelay: 2000
});

$(function() {
	$("#patentes").submit(function() {
		$resultado=$("#patentes").validationEngine("validate");
		if ($resultado) {
			return true;
		}
		return false;
	});
});

$("#patentesRegistrar").validationEngine({
	promptPosition : "bottomRight:-150", 
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});

$(function() {
$("#patentesRegistrar").submit(function() {
$resultado=$("#patentesRegistrar").validationEngine("validate");

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
	$("#patentesModificar").submit(function() {
		$resultado=$("#patentesModificar").validationEngine("validate");
		if ($resultado) {
			return true;
		}
		return false;
	});
});

$("#patentesModificar").validationEngine({
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
$('#<?php echo $this->campoSeguro('tipoPatente')?>').width(450);
$('#<?php echo $this->campoSeguro('entidadPatente')?>').width(450);
$('#<?php echo $this->campoSeguro('pais')?>').width(450);
$('#<?php echo $this->campoSeguro('anno')?>').width(450);

//////////////////**********Se definen los campos que requieren campos de select2**********////////////////

$("#<?php echo $this->campoSeguro('facultad')?>").select2();
$("#<?php echo $this->campoSeguro('proyectoCurricular')?>").select2();

$('#<?php echo $this->campoSeguro('tipoPatente')?>').select2();
$('#<?php echo $this->campoSeguro('entidadPatente')?>').select2();
$('#<?php echo $this->campoSeguro('pais')?>').select2();
$('#<?php echo $this->campoSeguro('anno')?>').select2();

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
