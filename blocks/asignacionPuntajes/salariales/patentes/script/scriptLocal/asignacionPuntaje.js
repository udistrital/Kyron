$( document ).ready(function() {

	/*SEGÚN ESPECIFICACIÓN DE CASO DE USO 22. REGISTRAR PATENTES
	 Puntaje asignado (Máximo 25 Puntos salariales)
	 */
	
	asignarPuntaje();

	$("#<?php echo $this->campoSeguro('puntaje')?>").focus(function(){		
		asignarPuntaje();
	});
	
	function asignarPuntaje(){
		$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[25]]");
	}
});
