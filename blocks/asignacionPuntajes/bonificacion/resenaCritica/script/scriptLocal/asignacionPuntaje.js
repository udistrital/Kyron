$( document ).ready(function() {

	/*SEGÚN ESPECIFICACIÓN DE CASO DE USO 30. RESEÑA CRITICA
		Puntaje asignado (El puntaje máximo será hasta 12 puntos de bonificación).
	 */

	asignarPuntaje();	
	
	function asignarPuntaje(){
		$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[12]]");
	}
});
