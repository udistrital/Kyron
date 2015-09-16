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
$('#<?php echo $this->campoSeguro('tipoLibro')?>').width(450);
$('#<?php echo $this->campoSeguro('annoLibro')?>').width(450);

$('#<?php echo $this->campoSeguro('editorial')?>').width(450);

$('#<?php echo $this->campoSeguro('entidadCertificadora1')?>').width(300);
$('#<?php echo $this->campoSeguro('entidadCertificadora2')?>').width(300);
$('#<?php echo $this->campoSeguro('entidadCertificadora3')?>').width(300);


//////////////////**********Se definen los campos que requieren campos de Select2**********////////////////

$("#<?php echo $this->campoSeguro('facultad')?>").select2();
$("#<?php echo $this->campoSeguro('proyectoCurricular')?>").select2();


$("#<?php echo $this->campoSeguro('tipoLibro')?>").select2();
$("#<?php echo $this->campoSeguro('annoLibro')?>").select2();
$("#<?php echo $this->campoSeguro('editorial')?>").select2();


$("#<?php echo $this->campoSeguro('entidadCertificadora1')?>").select2();
$("#<?php echo $this->campoSeguro('entidadCertificadora2')?>").select2();
$("#<?php echo $this->campoSeguro('entidadCertificadora3')?>").select2();

<!-- document.getElementsByTagName('label')[5].firstChild.data.innerHTML="Hola"; -->

<!-- var label = document.querySelector('label[for="categoria"]'); -->
<!-- // change it's content -->
<!-- label.textContent = 'Emmanuel' -->