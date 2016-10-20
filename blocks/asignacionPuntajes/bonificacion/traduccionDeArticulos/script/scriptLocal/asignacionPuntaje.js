$( document ).ready(function() {

	/*SEGÚN ESPECIFICACIÓN DE CASO DE USO 31. REGISTRAR TRADUCCIONES
		Puntaje asignado: El puntaje máximo será hasta 36 puntos por bonificación.
	 */

	asignarPuntaje();	
	
	function asignarPuntaje(){
		$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[36]]");
	}
});
