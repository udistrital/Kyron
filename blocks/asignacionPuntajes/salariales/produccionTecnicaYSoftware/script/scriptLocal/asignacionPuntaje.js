$( document ).ready(function() {

	/*SEGÚN ESPECIFICACIÓN DE CASO DE USO 26. REGISTRAR PRODUCCIÓN TÉCNICA Y SOFTWARE
		Innovación (Máximo 15 puntos)
		Adaptación (Máximo 8 puntos)
		Software (Máximo 15 Puntos)
	 */
	
	asignarPuntaje();

	$("#<?php echo $this->campoSeguro('tipo')?>").change(function(){	
		asignarPuntaje();
	});
	
	function asignarPuntaje(){
		
		var tipo = $("#<?php echo $this->campoSeguro('tipo')?>").val();
		
		if(tipo == 1){
			$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[15]]");

		}else if(tipo == 2){
			$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[8]]");
		}else if(tipo == 3){
			$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[15]]");
		}else{
			$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number]]");
		}
	}
});
