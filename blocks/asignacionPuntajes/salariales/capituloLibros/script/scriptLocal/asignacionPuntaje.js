$( document ).ready(function() {

	asignarPuntaje();

	$("#<?php echo $this->campoSeguro('tipoLibro')?>").change(function(){
		asignarPuntaje();
	});
	
	function asignarPuntaje(){
		var tipo = $("#<?php echo $this->campoSeguro('tipoLibro')?>").val();
		if(tipo == ""){
			$("#<?php echo $this->campoSeguro('puntajeLibro')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1]]");
		}else if(tipo == 1){
			$("#<?php echo $this->campoSeguro('puntajeLibro')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[20]]");
		}else if(tipo==2){
			$("#<?php echo $this->campoSeguro('puntajeLibro')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[15]]");
		}else if(tipo == 3){
				$("#<?php echo $this->campoSeguro('puntajeLibro')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[15]]");
		}
	}
});
