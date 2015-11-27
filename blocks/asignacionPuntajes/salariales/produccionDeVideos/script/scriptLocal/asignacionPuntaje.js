$( document ).ready(function() {

	/*SEGÚN ESPECIFICACIÓN DE CASO DE USO 19. REGISTRAR PRODUCCIÓN DE VIDEOS
		Nacional: 7 Puntos salariales
		Internacional: 12 Puntos salariales
	 */

	asignarPuntaje();
	
	$("#<?php echo $this->campoSeguro('impacto')?>").change(function(){	
		asignarPuntaje();
	});
	
	function asignarPuntaje(){
		
		var impacto = $("#<?php echo $this->campoSeguro('impacto')?>").val();
		
		if(impacto == 1){
			$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[7]]");
		}else if(impacto == 2){
			$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[12]]");
		}else{
			$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number]]");
		}
	}
});
