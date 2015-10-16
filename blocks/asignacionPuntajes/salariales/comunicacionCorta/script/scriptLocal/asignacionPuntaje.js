$( document ).ready(function() {

	//Puntaje asignado: El puntaje no podrá ser mayor al 60 % del total de puntos
	//Los puntajes máximos asignados corresponden al 60% del puntaje total
	//Por ejemplo para una indexación nacional A1 son 15 puntos, el 60% corresponde a 9
	//Este 9 es el puntaje máximo que se podra asignar al docente.

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
		alert(categoria);
		if(contexto == "" || categoria == ""){
			$("#<?php echo $this->campoSeguro('puntajeRevista')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1]");
		}else{
			if(categoria == 4 || categoria == 0){
				$("#<?php echo $this->campoSeguro('puntajeRevista')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[9]]");
			}else if(categoria == 5 || categoria == 1 ){
				$("#<?php echo $this->campoSeguro('puntajeRevista')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[7.2]]");
			}else if(categoria == 6 || categoria == 2){
				$("#<?php echo $this->campoSeguro('puntajeRevista')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[4.8]]");
			}else if(categoria == 7 || categoria == 3){
				$("#<?php echo $this->campoSeguro('puntajeRevista')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[1.8]]");
			}
		}
	}
});
