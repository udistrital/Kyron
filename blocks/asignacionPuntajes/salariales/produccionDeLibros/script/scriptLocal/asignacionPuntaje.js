$( document ).ready(function() {

	/*SEGÚN ESPECIFICACIÓN DE CASO DE USO 20. REGISTRAR PRODUCCIÓN DE LIBROS
		Investigación: Puntaje máximo 20
		Ensayo: Puntaje máximo  15
		Texto: Puntaje máximo 15
	 */
	
	asignarPuntaje();

	$("#<?php echo $this->campoSeguro('tipoLibro')?>").change(function(){	
		asignarPuntaje();
	});
	
	function asignarPuntaje(){
		$("#<?php echo $this->campoSeguro('puntajeLibro')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[20]]");
	}
});
