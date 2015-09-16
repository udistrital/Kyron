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


$(campoValidar).each(function(){
	jQuery(this.valueOf()).keypress(function(tecla) {
		if(tecla.charCode < 48 || tecla.charCode > 57){
			if(tecla.charCode != 0){
				return false;
			}
		}
	})
});

var cont = 0;
var numero = 0;
$(campoValidarPunto).each(function(){
	jQuery(this.valueOf()).keypress(function(tecla) {
		if(tecla.charCode < 48 || tecla.charCode > 57){
			if(tecla.charCode != 46 || cont>0 || numero==0){
				if(tecla.charCode != 0){
					return false;
				}
			}else{
				cont++;
			}			
		}else{
			numero++;
		}
	})
});

</script>



