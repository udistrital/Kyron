$( document ).ready(function() {
	/*PUNTAJES ASIGNADOS SEGÚN CATEGORÍA DOCENTE
	Categoría Docente (lista desplegable)
	Titular     Puntos: 2.5
	Asociado	Puntos: 2.0
	Asistente	Puntos: 1.5
	Auxiliar	Puntos: 1
	*/
	
	asignarPuntaje();

	function asignarPuntaje(){
		$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.0],max[2.5]]");
	}
});
