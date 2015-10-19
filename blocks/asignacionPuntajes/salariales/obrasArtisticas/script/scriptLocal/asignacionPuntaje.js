$( document ).ready(function() {

	/*SEGÚN ESPECIFICACIÓN DE CASO DE USO 24. REGISTRAR OBRAS ARTÍSTICAS

		Los puntajes se deben restringir de la siguiente manera:

		* Creación original

			Nacional: 14 Puntos
			Internacional: 20 Puntos

		* Creación complementaria

			Nacional:8 Puntos
			Internacional: 12 Puntos

		* Interpretación

			Nacional: 8 Puntos
			Internacional: 14 Puntos

	 */

	asignarPuntaje();

	$("#<?php echo $this->campoSeguro('puntaje')?>").focus(function(){
		asignarPuntaje();
	});
	
	function asignarPuntaje(){
		var contexto = $("#<?php echo $this->campoSeguro('contexto')?>").val();
		var tipoObra = $("#<?php echo $this->campoSeguro('tipoObraArt')?>").val();
		if(contexto == ""){
			$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1]");
		}else if(contexto == 1){
			if(tipoObra == 1){
				$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[14]]");
			}else if(tipoObra == 2){
				$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[8]]");
			}else if(tipoObra == 3){
				$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[8]]");
			}
		}else if(contexto == 2){
			if(tipoObra == 1){
				$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[20]]");
			}else if(tipoObra == 2){
				$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[12]]");
			}else if(tipoObra == 3){
				$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[14]]");
			}
		}
	}
});
