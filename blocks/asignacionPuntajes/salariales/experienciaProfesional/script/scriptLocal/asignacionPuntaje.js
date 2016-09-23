$( document ).ready(function() {

	/*SEGUN EL CASO DE USO 15. REGISTRAR EXPERIENCIA PROFESIONAL*/
	
	var puntajeAnnio = 3;
	asignarPuntaje();
	
	$("#<?php echo $this->campoSeguro('puntaje')?>").focus(function() {
		asignarPuntaje();
	});
		
	function asignarPuntaje(){
		var diasExperiencia = calcularDias();			
		puntajeMaximo = redondeo(diasExperiencia*(puntajeAnnio/365), 3);		
		$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max["+puntajeMaximo+"]");
	}
	
	function redondeo(numero, decimales)
	{
		var flotante = parseFloat(numero);
		var resultado = Math.round(flotante*Math.pow(10,decimales))/Math.pow(10,decimales);
		return resultado;
	}

	function calcularDias(){
		var fecha1 = new Date($("#<?php echo $this->campoSeguro('fechaInicio')?>").val());
		var fecha2 = new Date($("#<?php echo $this->campoSeguro('fechaFinalizacion')?>").val());
		if(fecha1 != "" && fecha2 != ""){
			var diasDif = fecha2.getTime() - fecha1.getTime();
			var dias = Math.round(diasDif/(1000 * 60 * 60 * 24));
			return dias;
		}
	}
	

});
