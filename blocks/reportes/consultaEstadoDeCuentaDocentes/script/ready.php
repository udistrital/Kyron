<?php 
$nombrePagina = $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
$nombreBloque = $this->miConfigurador->getVariableConfiguracion ( 'esteBloque' )['nombre'];
?>
/////////Se define el ancho de los campos de listas desplegables///////
$('#<?php echo $this->campoSeguro('docente')?>').width(465);


$("#<?php echo $nombrePagina;?>").validationEngine({
	promptPosition : "bottomRight:-150",
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});




$(".checkbox-verificacion").attr('disabled','disabled');
$(".checkbox-verificacion").addClass("selected");

$(".text-observacion").attr('disabled','disabled');
$(".text-observacion").addClass("selected");


//Se utiliza para cargar elementos del builder
if(typeof(_arregloCreacionElementos)!="undefined"){
$.each(_arregloCreacionElementos,function(){
	this();
});
}