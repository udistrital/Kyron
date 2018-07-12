<?php
/**
 * @author Jorge Ulises Useche Cuellar
 * Cargue todas las funciones que desea llamar en una super función llamada "cargarElemento" que actuará como un listener al finalizar el archivo
 * Ejemplo:
 * var cargarElemento = function() {***Funciones que inicializan el elemento***}
 * o
 * function cargarElemento (){***Funciones que inicializan el elemento***}
 * !Importante¡ No genere código de ejecución que necesite las bibliotecas Javascript que están en el archivo "Script.php" fuera de una función bien definida.
 * ¡¡¡ OJO !!! Para que todo esto cargue al finalizar la página recuerde agregar en el archivo ready.php
 * $.each(_arregloCreacionElementos,function(){ this(); });
 */
?>
<script type='text/javascript'>
//Importante que la función se llame cargar elemento.
var cargarElemento = function() {
	$('#<?php echo $this->atributos['id'];?>').dataTable( {
		"sPaginationType": "full_numbers"
	});
};
</script>