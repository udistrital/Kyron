<script type='text/javascript'>

var campoValidar = [];
var campoValidarPunto = [];

var INumero = 0; 
var IPunto = 0;

campoValidar[INumero++] = "#<?php echo $this->campoSeguro('numeroCasoActa')?>";

campoValidarPunto[IPunto++] = "#<?php echo $this->campoSeguro('puntaje')?>";

$(campoValidar).each(function(){
	$(this.valueOf()).keydown(function(tecla) {
		if(tecla.keyCode < 8 || tecla.keyCode > 57){
			return false;
		}
	})
});

$(campoValidarPunto).each(function(){
	$(this.valueOf()).keydown(function(tecla) {
		if(tecla.keyCode < 8 || tecla.keyCode > 57){
			if(tecla.keyCode != 190  || ($(this).val()).indexOf(".") > -1 || ($(this).val()).length == 0){
				return false;
			}
		}
	})
});

</script>



