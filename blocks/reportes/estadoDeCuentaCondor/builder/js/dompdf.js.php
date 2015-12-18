<?php
/**
 * @author Jorge Ulises Useche Cuellar
 * Cargue todas las funciones que desea llamar en una super función llamada "cargarElemento" que actuará como un listener al finalizar el archivo
 * Ejemplo:
 * var cargarElemento = function() {***Funciones que inicializan el elemento***}
 * o
 * function cargarElemento (){***Funciones que inicializan el elemento***}
 * !Importante¡ No genere código de ejecución que necesite las bibliotecas Javascript que están en el archivo "Script.php" fuera de una función bien definida.
 */
?>
<script type='text/javascript'>
//Importante que la función se llame cargar elemento.
var cargarElemento = function() {
	//En esta configuración no se aceptan los "allDayEvent", "Repeating Event" por lo tanto darán error porque no tienen "end" time moment
	//	{
	//		"title": "All Day Event",
	//		"start": "2015-02-01"
	//	}
};
</script>