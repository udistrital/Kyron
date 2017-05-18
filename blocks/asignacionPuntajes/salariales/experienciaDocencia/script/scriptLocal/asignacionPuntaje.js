$( document ).ready(function() {

	/*SEGUN EL CASO DE USO 14. REGISTRAR EXPERIENCIA EN DIRECCIÓN ACADEMICA
	 * 
	 * Puntaje asignado (4 puntos salariales por un año de Experiencia 
	 *y el máximo de puntaje  de acuerdo a la relación duración en días con respecto a los al año de experiencia)
     *4 Puntos maximos-------->1 Año (365 dias)
     *(Puntos maximos)---------> Duracion(dias) 
     *un dia equivale a 0.01095890411*
     *Para calcular el máximo puntaje que se puede asignar se divide 4 que es el máximo puntaje por año
     *y se divide en 365 días dando como resultado el factor por el que se debe multiplicar cada día
     *para ir incrementando el puntaje máximo dependiendo de la cantidad de días que ingrese como expeiencia.*/

	var diasExperiencia;
	var puntajeAnnio = 4;
	asignarPuntaje();
	
	$("#<?php echo $this->campoSeguro('duracionExperiencia')?>").blur(function() {
		asignarPuntaje();
	});
		
	function asignarPuntaje(){
		
		diasExperiencia = $("#<?php echo $this->campoSeguro('duracionExperiencia')?>").val();
		puntajeMaximo = redondeo(diasExperiencia*(puntajeAnnio/365), 3);
		var fechaSeleccionada = $("#<?php echo $this->campoSeguro('fechaActaLibro')?>").datepicker("getDate");
		if (fechaSeleccionada < new Date('2016-01-01')){
			window.alert('Está en el modo sin restricciones.');
			puntajeMaximo = 4;
		}
		$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.0],max["+puntajeMaximo+"]");
	}
	
	function redondeo(numero, decimales)
	{
	var flotante = parseFloat(numero);
	var resultado = Math.round(flotante*Math.pow(10,decimales))/Math.pow(10,decimales);
	return resultado;
	}

});
