<script type='text/javascript'>

var campoValidar = [];
var campoValidarPunto = [];

var indiceA = 0;
var indiceB = 0;

campoValidar[indiceA++] = "#<?php echo $this->campoSeguro('numeroAutoresLibro')?>";
campoValidar[indiceA++] = "#<?php echo $this->campoSeguro('numeroAutoresUniversidad')?>";
campoValidar[indiceA++] = "#<?php echo $this->campoSeguro('numeroActaLibro')?>";

campoValidarPunto[indiceB++] = "#<?php echo $this->campoSeguro('puntajeSugeridoEvaluador1')?>";
campoValidarPunto[indiceB++] = "#<?php echo $this->campoSeguro('puntajeSugeridoEvaluador2')?>";
campoValidarPunto[indiceB++] = "#<?php echo $this->campoSeguro('puntajeSugeridoEvaluador3')?>";
campoValidarPunto[indiceB++] = "#<?php echo $this->campoSeguro('puntajeLibro')?>";

/*
 * En los id's del arreglo campoValidar están todos los input que son integer / números enteros
 */
$.each(campoValidar,function(i,v){
	$(v).keypress(function(event) {
		var char = event.which || event.keyCode;
		// Si no son carácteres diferentes a números o tab incluso del teclado numérico retorna false 
		if(!((char >= 48 && char <= 57) || (char >= 96 && char <= 105 || char == 9))){
			return false;
		}
	});
});

/*
 * En los id's del arreglo campoValidarPunto están todos los input que son number / números con punto
 */
$.each(campoValidarPunto,function(i,v){
	$(v).keydown(function(event) {
		var char = event.which || event.keyCode;
		// Si no son carácteres numéricos o punto o tab retorna false
		//http://www.cambiaresearch.com/articles/15/javascript-char-codes-key-codes
		if(!((char >= 48 && char <= 57) || char == 190 || (char >= 96 && char <= 105) || char == 110 || char == 9)){
			return false;
		}
	});
});

</script>



