$( document ).ready(function() {

	/*SEGÚN ESPECIFICACIÓN DE CASO DE USO 29. REGISTRAR ESTUDIOS POSTDOCTORALES
		Puntaje asignado (Puntaje máximo de 120)
	 */

	asignarPuntaje();	
	
	function asignarPuntaje(){
		$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[120]]");
	}
});
