$( document ).ready(function() {

	/*SEGUN EL CASO DE USO 14. REGISTRAR EXPERIENCIA EN DIRECCIÓN ACADEMICA
	 * 
	 * Puntaje asignado (4 puntos salariales por un año de Experiencia 
	 *y el máximo de puntaje  de acuerdo a la relación duración en días con respecto a los al año de experiencia)
     *6 Puntos maximos-------->1 Año (365 dias)
     *(Puntos maximos)---------> Duracion(dias) 
     *un dia equivale a 0.01643835616*
     *Para calcular el máximo puntaje que se puede asignar se divide 6 que es el máximo puntaje por año
     *y se divide en 365 días dando como resultado el factor por el que se debe multiplicar cada día
     *para ir incrementando el puntaje máximo dependiendo de la cantidad de días que ingrese como experiencia.*/
	
	var puntajeAnnio = 6;
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
