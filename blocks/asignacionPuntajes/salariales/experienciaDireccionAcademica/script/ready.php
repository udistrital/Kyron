$("#experienciaDireccionAcademica").validationEngine({
promptPosition : "centerRight", 
scroll: false,
autoHidePrompt: true,
autoHideDelay: 2000
});

$(function() {
	$("#experienciaDireccionAcademica").submit(function() {
		$resultado=$("#experienciaDireccionAcademica").validationEngine("validate");
		if ($resultado) {
			return true;
		}
		return false;
	});
});

$("#experienciaDireccionAcademicaRegistrar").validationEngine({
	promptPosition : "centerRight", 
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});

$(function() {
$("#experienciaDireccionAcademicaRegistrar").submit(function() {
$resultado=$("#experienciaDireccionAcademicaRegistrar").validationEngine("validate");

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
	$("#experienciaDireccionAcademicaModificar").submit(function() {
		$resultado=$("#experienciaDireccionAcademicaModificar").validationEngine("validate");
		if ($resultado) {
			return true;
		}
		return false;
	});
});

$("#experienciaDireccionAcademicaModificar").validationEngine({
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
$('#<?php echo $this->campoSeguro('tipoEntidad')?>').width(450);
$('#<?php echo $this->campoSeguro('entidad')?>').width(450);

//////////////////**********Se definen los campos que requieren campos de select2**********////////////////

$("#<?php echo $this->campoSeguro('facultad')?>").select2();
$("#<?php echo $this->campoSeguro('proyectoCurricular')?>").select2();

$("#<?php echo $this->campoSeguro('tipoEntidad')?>").select2();
$("#<?php echo $this->campoSeguro('entidad')?>").select2();

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$("#<?php echo $this->campoSeguro('entidad')?>").change(function() {
	if($("#<?php echo $this->campoSeguro('entidad')?>").val()==''){
		$("#<?php echo $this->campoSeguro('otraEntidad')?>").removeAttr("disabled");
	}else{
		$("#<?php echo $this->campoSeguro('otraEntidad')?>").attr("disabled", "disabled");
		$("#<?php echo $this->campoSeguro('otraEntidad')?>").val("");
	}
});