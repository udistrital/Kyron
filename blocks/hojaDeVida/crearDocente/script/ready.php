$("#crearDocente").validationEngine({
promptPosition : "centerRight", 
scroll: false,
autoHidePrompt: true,
autoHideDelay: 2000
});

$(function() {
	$("#crearDocente").submit(function() {
		$resultado=$("#crearDocente").validationEngine("validate");
		if ($resultado) {
			return true;
		}
		return false;
	});
});

var $formValidar = $("#crearDocenteRegistrar");

 $formValidar.validationEngine({
                //validateNonVisibleFields: true,
                promptPosition : "topRight", 
                scroll: false,
                autoHidePrompt: true,
                autoHideDelay: 2000
            });        
            
$("#crearDocenteRegistrar").validationEngine({
	promptPosition : "centerRight", 
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});


$formValidar.formToWizard({
                submitButton: '<?php echo $this->campoSeguro('botonRegistrar')?>A',
                showProgress: true, 
                nextBtnName: 'Siguiente >>',
                prevBtnName: '<< Anterior',
                showStepNo: true,                
                validateBeforeNext: function() {
                	return $formValidar.validationEngine( 'validate' );
                }
            });
            

$(function() {
$("#crearDocenteRegistrar").submit(function() {
$resultado=$("#crearDocenteRegistrar").validationEngine("validate");

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
	$("#crearDocenteModificar").submit(function() {
		$resultado=$("#crearDocenteModificar").validationEngine("validate");
		if ($resultado) {
			return true;
		}
		return false;
	});
});

$("#crearDocenteModificar").validationEngine({
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
$('#<?php echo $this->campoSeguro('dedicacion')?>').width(450);      

$('#<?php echo $this->campoSeguro('docenteRegistrar')?>').width(465);
$('#<?php echo $this->campoSeguro('tipoDocumento')?>').width(450);
$('#<?php echo $this->campoSeguro('categoriaActualDocente')?>').width(450);

//////////////////**********Se definen los campos que requieren campos de select2**********////////////////

$("#<?php echo $this->campoSeguro('facultad')?>").select2();
$("#<?php echo $this->campoSeguro('proyectoCurricular')?>").select2();
$("#<?php echo $this->campoSeguro('tipoDocumento')?>").select2();
$('#<?php echo $this->campoSeguro('categoriaActualDocente')?>').select2();
$('#<?php echo $this->campoSeguro('dedicacion')?>').select2();

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////