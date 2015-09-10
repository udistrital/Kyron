<script type='text/javascript'>

var campoValidar;

campoValidar = "#<?php echo $this->campoSeguro('puntajeRevista')?>";
validarNumeroPunto(campoValidar);
campoValidar = "#<?php echo $this->campoSeguro('numeroCasoActaRevista')?>";
validar(campoValidar);
campoValidar = "#<?php echo $this->campoSeguro('numeroAutoresUniversidad')?>";
validar(campoValidar);
campoValidar = "#<?php echo $this->campoSeguro('numeroAutoresRevista')?>";
validar(campoValidar);
campoValidar = "#<?php echo $this->campoSeguro('paginasRevista')?>";
validar(campoValidar);
campoValidar = "#<?php echo $this->campoSeguro('numeroRevista')?>";
validar(campoValidar);
campoValidar = "#<?php echo $this->campoSeguro('volumenRevista')?>";
validar(campoValidar);



function validar(campo){
	jQuery(campo).keypress(function(tecla) {
		if(tecla.charCode < 48 || tecla.charCode > 57){
			if(tecla.charCode != 0){
				return false;
			}
			
		}
	});
}

var cont = 0;
var numero = 0;
function validarNumeroPunto(campo){
	jQuery(campo).keypress(function(tecla) {
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
	});
}

</script>



