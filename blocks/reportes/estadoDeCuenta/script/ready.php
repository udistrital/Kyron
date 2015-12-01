$("#cartasEditor").validationEngine({
promptPosition : "bottomRight:-150", 
scroll: false,
autoHidePrompt: true,
autoHideDelay: 2000
});

$(function() {
	$("#cartasEditor").submit(function() {
		$resultado=$("#cartasEditor").validationEngine("validate");
		if ($resultado) {
			return true;
		}
		return false;
	});
});

$("#cartasEditorRegistrar").validationEngine({
	promptPosition : "bottomRight:-150", 
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});

$(function() {
$("#cartasEditorRegistrar").submit(function() {
$resultado=$("#cartasEditorRegistrar").validationEngine("validate");

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
	$("#cartasEditorModificar").submit(function() {
		$resultado=$("#cartasEditorModificar").validationEngine("validate");
		if ($resultado) {
			return true;
		}
		return false;
	});
});

$("#cartasEditorModificar").validationEngine({
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
$('#<?php echo $this->campoSeguro('contexto')?>').width(450);
$('#<?php echo $this->campoSeguro('anno')?>').width(450);


///*********El ancho (width) de los siguientes campos es mayor debido a que se encuentran dentro de un div****///
$('#<?php echo $this->campoSeguro('pais')?>').width(470);
$('#<?php echo $this->campoSeguro('categoria')?>').width(470);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//////////////////**********Se definen los campos que requieren campos de select2**********////////////////

$("#<?php echo $this->campoSeguro('facultad')?>").select2();
$("#<?php echo $this->campoSeguro('proyectoCurricular')?>").select2();

$("#<?php echo $this->campoSeguro('contexto')?>").select2();
$("#<?php echo $this->campoSeguro('anno')?>").select2();

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*Se limpia el campo de doncente a consultar o a registrar cuando no se realiza
una elección del listado desplegado*/

$("#<?php echo $this->campoSeguro('docente')?>").blur(function() {
 	$("#<?php echo $this->campoSeguro('docente')?>").val("");
});

$("#<?php echo $this->campoSeguro('docenteRegistrar')?>").blur(function() {
 	$("#<?php echo $this->campoSeguro('docenteRegistrar')?>").val("");
});

