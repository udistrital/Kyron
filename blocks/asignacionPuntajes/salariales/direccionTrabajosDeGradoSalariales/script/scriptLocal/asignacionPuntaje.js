$( document ).ready(function() {

	asignarPuntaje();

	$("#<?php echo $this->campoSeguro('tipo')?>").change(function(){
		asignarPuntaje();
	});
	
	$("#<?php echo $this->campoSeguro('categoria')?>").change(function(){
		asignarPuntaje();
	});
	
	function asignarPuntaje(){
		var tipo = $("#<?php echo $this->campoSeguro('tipo')?>").val();
		var categoria = $("#<?php echo $this->campoSeguro('categoria')?>").val();
		if(tipo == 1){//maestria
			if(categoria == 1){
				$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[20]]");
			}else if(categoria == 2){
				$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[32]]");
			}else if(categoria == 3){
				$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[36]]");
			}
		}else if(tipo==2){//doctorado
			if(categoria == 1){
				$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[62]]");
			}else if(categoria == 2){
				$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[70]]");
			}else if(categoria == 3){
				$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[72]]");
			}
		}else if(tipo==3){//pregrado
			if(categoria == 1){
				$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0],max[2]]");
			}else if(categoria == 2){
				$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0],max[2]]");
			}else if(categoria == 3){
				$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0],max[2]]");
			}
		}else if(tipo==4){//especializacion
			if(categoria == 1){
				$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0],max[0]]");
			}else if(categoria == 2){
				$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0],max[0]]");
			}else if(categoria == 3){
				$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0],max[0]]");
			}
		}
	}
});
