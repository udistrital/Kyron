$("#novedadesSalariales").validationEngine({
promptPosition : "bottomRight:-150", 
scroll: false,
autoHidePrompt: true,
autoHideDelay: 2000
});

$(function() {
	$("#cambioCategoria").submit(function() {
		$resultado=$("#novedadesSalariales").validationEngine("validate");
		if ($resultado) {
			return true;
		}
		return false;
	});
});

$("#cambioCategoria").validationEngine({
	promptPosition : "bottomRight:-150", 
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});

$(function() {
$("#cambioCategoriaRegistrar").submit(function() {
$resultado=$("#cambioCategoriaRegistrar").validationEngine("validate");

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
	$("#cambioCategoriaModificar").submit(function() {
		$resultado=$("#novedadesSalarialesModificar").validationEngine("validate");
		if ($resultado) {
			return true;
		}
		return false;
	});
});

$("#cambioCategoriaModificar").validationEngine({
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
$('#<?php $tip = $this->campoSeguro('tipoCategoria'); echo $tip ?>').width(450);
$('#<?php $mot = $this->campoSeguro('motivoCategoria'); echo $mot ?>').width(450);

///*********El ancho (width) de los siguientes campos es mayor debido a que se encuentran dentro de un div****///
//$('#<?php echo $this->campoSeguro('pais')?>').width(470);
//$('#<?php echo $this->campoSeguro('categoria')?>').width(470);

$("#<?php echo $tip?>").select2();
$("#<?php echo $mot?>").select2();

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//////////////////**********Se definen los campos que requieren campos de autocompletar**********////////////////

$("#<?php echo $this->campoSeguro('facultad')?>").select2();
$("#<?php echo $this->campoSeguro('proyectoCurricular')?>").select2();



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*Se limpia el campo de doncente a consultar o a registrar cuando no se realiza
una elección del listado desplegado*/

$("#<?php echo $this->campoSeguro('docente')?>").blur(function() {
 	$("#<?php echo $this->campoSeguro('docente')?>").val("");
});

$("#<?php echo $this->campoSeguro('docenteRegistrar')?>").blur(function() {
 	$("#<?php echo $this->campoSeguro('docenteRegistrar')?>").val("");
});
