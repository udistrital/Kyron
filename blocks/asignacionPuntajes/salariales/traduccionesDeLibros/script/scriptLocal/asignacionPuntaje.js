$( document ).ready(function() {

	/*SEGÚN ESPECIFICACIÓN DE CASO DE USO 23. REGISTRAR TRADUCCIONES DE LIBROS

		Puntaje asignado (Máximo 15 Puntos salariales)
	 */

	asignarPuntaje();	
	
	function asignarPuntaje(){
		$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[15]]");
	}
});
