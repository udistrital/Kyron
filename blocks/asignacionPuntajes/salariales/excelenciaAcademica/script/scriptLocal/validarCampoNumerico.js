$( document ).ready(function() {
	
	var campoValidar = [];
	var campoValidarPunto = [];
	
	var INumero = 0; 
	var IPunto = 0;
	
	campoValidar[INumero++] = "#<?php echo $this->campoSeguro('numeroResolucion')?>";

	campoValidarPunto[IPunto++] = "#<?php echo $this->campoSeguro('puntaje')?>";
	
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

});


