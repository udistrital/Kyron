<script type='text/javascript'>

var campoValidar = [];
var campoValidarPunto = [];

var INumero = 0; 
var IPunto = 0;

campoValidar[INumero++] = "#<?php echo $this->campoSeguro('numeroAutoresLibro')?>";
campoValidar[INumero++] = "#<?php echo $this->campoSeguro('numeroAutoresUniversidad')?>";
campoValidar[INumero++] = "#<?php echo $this->campoSeguro('numeroCasoActaLibro')?>";
campoValidar[INumero++] = "#<?php echo $this->campoSeguro('numeroActaLibro')?>";

campoValidarPunto[IPunto++] = "#<?php echo $this->campoSeguro('puntajeSugeridoEvaluador1')?>";
campoValidarPunto[IPunto++] = "#<?php echo $this->campoSeguro('puntajeSugeridoEvaluador2')?>";
campoValidarPunto[IPunto++] = "#<?php echo $this->campoSeguro('puntajeSugeridoEvaluador3')?>";
campoValidarPunto[IPunto++] = "#<?php echo $this->campoSeguro('puntajeLibro')?>";

$(campoValidar).each(function(){
	$(this.valueOf()).keydown(function(tecla) {
		if(tecla.keyCode < 8 || tecla.keyCode > 57){
			if(tecla.keyCode < 96 || tecla.keyCode > 105){
				return false;
			}
		}
	})
});

$(campoValidarPunto).each(function(){
	$(this.valueOf()).keydown(function(tecla) {
		if(tecla.keyCode < 8 || tecla.keyCode > 57){
			if(tecla.keyCode < 96 || tecla.keyCode > 105){
				if((tecla.keyCode != 110 && tecla.keyCode != 190) || ($(this).val()).indexOf(".") > -1 || ($(this).val()).length == 0){
					return false;
				}
			}
		}
	})
});

</script>



