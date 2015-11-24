$("#experienciaCalificada").validationEngine({
promptPosition : "bottomRight:-150", 
scroll: false,
autoHidePrompt: true,
autoHideDelay: 2000
});

$(function() {
	$("#experienciaCalificada").submit(function() {
		$resultado=$("#experienciaCalificada").validationEngine("validate");
		if ($resultado) {
			return true;
		}
		return false;
	});
});

$("#experienciaCalificadaRegistrar").validationEngine({
	promptPosition : "bottomRight:-150", 
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});

$(function() {
$("#experienciaCalificadaRegistrar").submit(function() {
$resultado=$("#experienciaCalificadaRegistrar").validationEngine("validate");

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
	$("#experienciaCalificadaModificar").submit(function() {
		$resultado=$("#experienciaCalificadaModificar").validationEngine("validate");
		if ($resultado) {
			return true;
		}
		return false;
	});
});

$("#experienciaCalificadaModificar").validationEngine({
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
$('#<?php echo $this->campoSeguro('tipoExperiencia')?>').width(450);
$('#<?php echo $this->campoSeguro('annio')?>').width(450);
$('#<?php echo $this->campoSeguro('resolucionEmitidaPor')?>').width(450);

//////////////////**********Se definen los campos que requieren campos de select2**********////////////////

$("#<?php echo $this->campoSeguro('facultad')?>").select2();
$("#<?php echo $this->campoSeguro('proyectoCurricular')?>").select2();

$("#<?php echo $this->campoSeguro('annio')?>").select2();
$("#<?php echo $this->campoSeguro('tipoExperiencia')?>").select2();
$("#<?php echo $this->campoSeguro('resolucionEmitidaPor')?>").select2();

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*Se limpia el campo de doncente a consultar o a registrar cuando no se realiza
una elección del listado desplegado*/

$("#<?php echo $this->campoSeguro('docente')?>").blur(function() {
 	$("#<?php echo $this->campoSeguro('docente')?>").val("");
});

$("#<?php echo $this->campoSeguro('docenteRegistrar')?>").blur(function() {
 	$("#<?php echo $this->campoSeguro('docenteRegistrar')?>").val("");
});
