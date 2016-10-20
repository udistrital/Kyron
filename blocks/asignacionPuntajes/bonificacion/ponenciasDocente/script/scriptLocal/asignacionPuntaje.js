$( document ).ready(function() {

	/*SEGÚN ESPECIFICACIÓN DE CASO DE USO 27. REGISTRAR PONENCIAS
		Regional: Máximo 24 Puntos
		Nacional: Máximo 48 Puntos
		Internacional: Máximo  84 Puntos
	 */

	asignarPuntaje();	
	
	$("#<?php echo $this->campoSeguro('categoria')?>").change(function(){
		asignarPuntaje();	
	});
	
	function asignarPuntaje(){
		
		var categoria = $("#<?php echo $this->campoSeguro('categoria')?>").val();
		
		if(categoria == 1){
			$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[24]]");
		}else if(categoria == 2){
			$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[48]]");
		}else if(categoria == 3){
			$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[84]]");
		}else{
			$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number]]");
		}
	}
});
