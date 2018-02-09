$( document ).ready(function() {

	cambiarVisibilidad();
	
	<?php
		$pais = $this->campoSeguro('pais');
		$resolucion = $this->campoSeguro('resolucion');
		$fechaResolucion = $this->campoSeguro('fechaResolucion');
		$entidadConvalidacion = $this->campoSeguro('entidadConvalidacion');
	?>

	$("#<?php echo $resolucion?>").attr("class", "ui-widget ui-widget-content ui-corner-all  validate[required, maxSize[20]] ");
	$("#<?php echo $fechaResolucion?>").attr("class", "ui-widget ui-widget-content ui-corner-all  validate[required, custom[date]]  hasDatepicker");
	$("#<?php echo $entidadConvalidacion?>").attr("class", "ui-widget ui-widget-content ui-corner-all  validate[required, minSize[10],maxSize[30],custom[onlyLetterSp]]");
	
	$("#<?php echo $pais?>").change(function(){
		cambiarVisibilidad();
	});
	
	function cambiarVisibilidad(){
		var pais = $("#<?php echo $pais?>").val();
		if (pais == 'COL'){// colombia
			$("#<?php echo $resolucion?>").parent('.campoCuadroTexto').hide();
			$("#<?php echo $fechaResolucion?>").parent('.campoCuadroTexto').hide();
			$("#<?php echo $entidadConvalidacion?>").parent('.campoCuadroTexto').hide();
		} else {
			$("#<?php echo $resolucion?>").parent('.campoCuadroTexto').show();
			$("#<?php echo $fechaResolucion?>").parent('.campoCuadroTexto').show();
			$("#<?php echo $entidadConvalidacion?>").parent('.campoCuadroTexto').show();			
		}
	}
});
