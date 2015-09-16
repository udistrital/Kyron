<script type='text/javascript'>

var evaluadoRequerido = 0;
var evaluador = 3;
var numEvaluadores = evaluadoRequerido;
var indice = 0;

for(var i = evaluador; i > evaluadoRequerido; i--){
	$("#marcoEvaluador" + i).hide();
}

$("#botonEliminarEvaluador1").click(function( event ) { eliminarEvaluador1(); });
$("#botonEliminarEvaluador2").click(function( event ) { eliminarEvaluador2(); });
$("#botonEliminarEvaluador3").click(function( event ) { eliminarEvaluador3(); });

function eliminarEvaluador1()  {
	confirmar=confirm("¿Desea eliminar a esté evaluador?");  
    if (confirmar){
       	<?php for($i=1; $i<=3; $i++):?>        	 
        	$('#<?php echo $this->campoSeguro('documentoEvaluador'.$i)?>').val($('#<?php echo $this->campoSeguro('documentoEvaluador'.($i+1))?>').val());
       		$('#<?php echo $this->campoSeguro('nombreEvaluador'.$i)?>').val($('#<?php echo $this->campoSeguro('nombreEvaluador'.($i+1))?>').val());
       		$('#<?php echo $this->campoSeguro('entidadEvaluador'.$i)?>').val($('#<?php echo $this->campoSeguro('entidadEvaluador'.($i+1))?>').val());
       		$('#<?php echo $this->campoSeguro('puntajeSugeridoEvaluador'.$i)?>').val($('#<?php echo $this->campoSeguro('puntajeSugeridoEvaluador'.($i+1))?>').val());
            <?php if($i==3): ?>
           	   	$('#<?php echo $this->campoSeguro('documentoEvaluador'.$i)?>').val("");
           		$('#<?php echo $this->campoSeguro('nombreEvaluador'.$i)?>').val("");
           		$('#<?php echo $this->campoSeguro('entidadEvaluador'.$i)?>').val("");
           		$('#<?php echo $this->campoSeguro('puntajeSugeridoEvaluador'.$i)?>').val("");
            <?php endif; ?>
        <?php endfor; ?>
           
		numEvaluadores--;
			
		for(var i = evaluador; i > numEvaluadores; i--){
       		$("#marcoEvaluador" + i).hide();
       	}
    }
}

function eliminarEvaluador2()  {
	confirmar=confirm("¿Desea eliminar a esté evaluador?");  
    if (confirmar){
       	<?php for($i=2; $i<=3; $i++):?>        	 
        	$('#<?php echo $this->campoSeguro('documentoEvaluador'.$i)?>').val($('#<?php echo $this->campoSeguro('documentoEvaluador'.($i+1))?>').val());
       		$('#<?php echo $this->campoSeguro('nombreEvaluador'.$i)?>').val($('#<?php echo $this->campoSeguro('nombreEvaluador'.($i+1))?>').val());
       		$('#<?php echo $this->campoSeguro('entidadEvaluador'.$i)?>').val($('#<?php echo $this->campoSeguro('entidadEvaluador'.($i+1))?>').val());
       		$('#<?php echo $this->campoSeguro('puntajeSugeridoEvaluador'.$i)?>').val($('#<?php echo $this->campoSeguro('puntajeSugeridoEvaluador'.($i+1))?>').val());
            <?php if($i==3): ?>
           	   	$('#<?php echo $this->campoSeguro('documentoEvaluador'.$i)?>').val("");
           		$('#<?php echo $this->campoSeguro('nombreEvaluador'.$i)?>').val("");
           		$('#<?php echo $this->campoSeguro('entidadEvaluador'.$i)?>').val("");
           		$('#<?php echo $this->campoSeguro('puntajeSugeridoEvaluador'.$i)?>').val("");
            <?php endif; ?>
        <?php endfor; ?>
           
		numEvaluadores--;
			
		for(var i = evaluador; i > numEvaluadores; i--){
       		$("#marcoEvaluador" + i).hide();
       	}
    }
}

function eliminarEvaluador3()  {
	confirmar=confirm("¿Desea eliminar a esté evaluador?");  
    if (confirmar){
       	<?php for($i=3; $i<=3; $i++):?>        	 
            <?php if($i==3): ?>
           	   	$('#<?php echo $this->campoSeguro('documentoEvaluador'.$i)?>').val("");
           		$('#<?php echo $this->campoSeguro('nombreEvaluador'.$i)?>').val("");
           		$('#<?php echo $this->campoSeguro('entidadEvaluador'.$i)?>').val("");
           		$('#<?php echo $this->campoSeguro('puntajeSugeridoEvaluador'.$i)?>').val("");
            <?php endif; ?>
        <?php endfor; ?>
           
		numEvaluadores--;
			
		for(var i = evaluador; i > numEvaluadores; i--){
       		$("#marcoEvaluador" + i).hide();
       	}
    }
}
				
$(function() {
	$("#botonAgregarEvaluador").click(function( event ) {		
		if(numEvaluadores < 3){
			numEvaluadores++;
 			$("#marcoEvaluador"+ numEvaluadores).show();
		}
	});
}); 	
				
</script>