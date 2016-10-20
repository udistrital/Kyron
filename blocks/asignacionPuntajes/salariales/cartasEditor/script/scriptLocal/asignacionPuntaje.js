$( document ).ready(function() {

	//Puntaje asignado: El puntaje no podrá ser mayor al 30 % del total de puntos
	//Los puntajes máximos asignados corresponden al 30% del puntaje total
	//Por ejemplo para una indexación nacional A1 son 15 puntos, el 30% corresponde a 4.5
	//Este 4.5 es el puntaje máximo que se podra asignar al docente.

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
			$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1]");
		}else{
			if(categoria == 4 || categoria == 0){
				$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[4.5]]");
			}else if(categoria == 5 || categoria == 1 ){
				$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[3.6]]");
			}else if(categoria == 6 || categoria == 2){
				$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[2.4]]");
			}else if(categoria == 7 || categoria == 3){
				$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[0.9]]");
			}
		}
	}
});
