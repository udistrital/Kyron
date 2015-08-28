
$(function() {
	$("#tabs").tabs();
}); 

// Asociar el widget de validación al formulario
$("#indexacionRevista").validationEngine({
	promptPosition : "centerRight", 
    scroll: false,
    autoHidePrompt: true,
    autoHideDelay: 2000
});
	

$(function() {
	$("#indexacionRevista").submit(function() {
    	$resultado=$("#indexacionRevista").validationEngine("validate");
	    if ($resultado) {
	    	return true;
        }
    	return false;
    });
});


$("#<?php echo $this->campoSeguro('facultad')?>").select2();
$("#<?php echo $this->campoSeguro('proyectoCurricular')?>").select2();