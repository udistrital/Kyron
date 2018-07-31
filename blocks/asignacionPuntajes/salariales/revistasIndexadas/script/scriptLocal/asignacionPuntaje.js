$( document ).ready(function() {

	/*SEGÚN ESPECIFICACIÓN DE CASO DE USO 16. REVISTAS INDEXADAS
		Categoría (Lista desplegable):

		A1: 15 Puntos salariales
		A2: 12 Puntos salariales
		B: 8 Puntos salariales
		C: 3 Puntos salariales
		
		Indexación  (Lista desplegable):

		SRI- Publindex: 15 Puntos salariales
		Scopus: 12 Puntos salariales
		ISI: 8 Puntos salariales
		Scielo: 3 Puntos salariales*/

	asignarPuntaje();

	$("#<?php echo $this->campoSeguro('contexto')?>").change(function(){
		asignarPuntaje();
	});
	
	$("#<?php echo $this->campoSeguro('categoria')?>").change(function(){
		asignarPuntaje();
	});
	
	function asignarPuntaje(){
		var contexto = $("#<?php echo $this->campoSeguro('contexto')?>").val();
		var categoria = $("#<?php echo $this->campoSeguro('categoria')?>").val();
		if(contexto == "" || categoria == ""){
			$("#<?php echo $this->campoSeguro('puntajeRevista')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1]");
		}else{
			if(categoria == 4 || categoria == 0){
				$("#<?php echo $this->campoSeguro('puntajeRevista')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.05],max[15]]");
			}else if(categoria == 5 || categoria == 1 ){
				$("#<?php echo $this->campoSeguro('puntajeRevista')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.05],max[12]]");
			}else if(categoria == 6 || categoria == 2){
				$("#<?php echo $this->campoSeguro('puntajeRevista')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.05],max[8]]");
			}else if(categoria == 7 || categoria == 3){
				$("#<?php echo $this->campoSeguro('puntajeRevista')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.05],max[3]]");
			}
		}
	}
});
