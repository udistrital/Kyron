$("#direccionTrabajosDeGrado").validationEngine({
promptPosition : "centerRight", 
scroll: false,
autoHidePrompt: true,
autoHideDelay: 2000
});

$(function() {
	$("#direccionTrabajosDeGrado").submit(function() {
		$resultado=$("#direccionTrabajosDeGrado").validationEngine("validate");
		if ($resultado) {
			return true;
		}
		return false;
	});
});

$("#direccionTrabajosDeGradoRegistrar").validationEngine({
	promptPosition : "centerRight", 
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});

$(function() {
$("#direccionTrabajosDeGradoRegistrar").submit(function() {
$resultado=$("#direccionTrabajosDeGradoRegistrar").validationEngine("validate");

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
	$("#direccionTrabajosDeGradoModificar").submit(function() {
		$resultado=$("#direccionTrabajosDeGradoModificar").validationEngine("validate");
		if ($resultado) {
			return true;
		}
		return false;
	});
});

$("#direccionTrabajosDeGradoModificar").validationEngine({
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
$('#<?php echo $this->campoSeguro('categoria')?>').width(450);
$('#<?php echo $this->campoSeguro('tipo')?>').width(450);
$('#<?php echo $this->campoSeguro('anno')?>').width(450);

//////////////////**********Se definen los campos que requieren campos de select2**********////////////////

$("#<?php echo $this->campoSeguro('facultad')?>").select2();
$("#<?php echo $this->campoSeguro('proyectoCurricular')?>").select2();

$("#<?php echo $this->campoSeguro('categoria')?>").select2();
$("#<?php echo $this->campoSeguro('tipo')?>").select2();
$("#<?php echo $this->campoSeguro('contexto')?>").select2();
$("#<?php echo $this->campoSeguro('anno')?>").select2();

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
