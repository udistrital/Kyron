<?php 
//Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){

?>
	// Asociar el widget de validación al formulario
	$("#estadoCuenta").validationEngine({
		promptPosition : "centerRight",
		scroll : false
	});	
        
        $("#identificacion").keydown(function(event){
                    if((event.keyCode < 46 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105) && (event.keyCode!=8) && (event.keyCode!=9) && (event.keyCode < 37 || event.keyCode > 40)){
                   return false;
                       }
                    });
	
	$(function() {
		$("button").button().click(function(event) {
			event.preventDefault();
		});
	});
	
	
	// Asociar el widget tabs a la división cuyo id es tabs
	$(function() {
		$("#tabs").tabs();
	});
<?php 
}elseif(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]=="confirmar"){

?>
	$(function() {
	for(var i=0;i<=datos.length;i++){ jQuery("#gridConfirmarElementos").jqGrid('addRowData',i+1,datos[i])}
	});

<?php
}
?>
