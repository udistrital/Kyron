$( document ).ready(function() {
	
	var estudianteRequerido = 1;
	var estudiante = 3;
	var numEstudiante = estudianteRequerido;
	var indice = 0;
	
	for(var i = estudiante; i > estudianteRequerido; i--){
		$("#marcoEstudiante" + i).hide();
	}
	
	$("#botonEliminar1").click(function( event ) { eliminar1(); });
	$("#botonEliminar2").click(function( event ) { eliminar2(); });
	$("#botonEliminar3").click(function( event ) { eliminar3(); });
	
	function eliminar1()  {
		if(numEstudiante == estudianteRequerido){
			$('#<?php echo $this->campoSeguro('nombreEstudiante1')?>').val("");
			alert("Debe haber por lo menos un Estudiante");
	
		}else{
			confirmar=confirm("¿Desea eliminar a esté Estudiante?");  
		    if (confirmar){
		       	<?php for($i=1; $i<=3; $i++):?>      
		       		$('#<?php echo $this->campoSeguro('nombreEstudiante'.$i)?>').val($('#<?php echo $this->campoSeguro('nombreEstudiante'.($i+1))?>').val());
		            <?php if($i==3): ?>
		           		$('#<?php echo $this->campoSeguro('nombreEstudiante'.$i)?>').val("");
		            <?php endif; ?>
		        <?php endfor; ?>
		           
				numEstudiante--;
					
				for(var i = estudiante; i > numEstudiante; i--){
		       		$("#marcoEstudiante" + i).hide();
		       	}
		    }
		}
	}
	
	function eliminar2()  {
		if(numEstudiante == estudianteRequerido){
			$('#<?php echo $this->campoSeguro('nombreEstudiante2')?>').val("");
		}else{
			confirmar=confirm("¿Desea eliminar a esté Estudiante?");  
		    if (confirmar){
		       	<?php for($i=2; $i<=3; $i++):?>        	 
		       		$('#<?php echo $this->campoSeguro('nombreEstudiante'.$i)?>').val($('#<?php echo $this->campoSeguro('nombreEstudiante'.($i+1))?>').val());
		            <?php if($i==3): ?>
		           		$('#<?php echo $this->campoSeguro('nombreEstudiante'.$i)?>').val("");
		            <?php endif; ?>
		        <?php endfor; ?>
		           
				numEstudiante--;
					
				for(var i = estudiante; i > numEstudiante; i--){
		       		$("#marcoEstudiante" + i).hide();
		       	}
		    }
		}
	}
	
	function eliminar3()  {
		if(numEstudiante == estudianteRequerido){
			$('#<?php echo $this->campoSeguro('nombreEstudiante3')?>').val("");
		}else{
			confirmar=confirm("¿Desea eliminar a esté Estudiante?");  
		    if (confirmar){
		       	<?php for($i=3; $i<=3; $i++):?>        	 
		            <?php if($i==3): ?>
		           		$('#<?php echo $this->campoSeguro('nombreEstudiante'.$i)?>').val("");
		            <?php endif; ?>
		        <?php endfor; ?>
		           
				numEstudiante--;
					
				for(var i = estudiante; i > numEstudiante; i--){
		       		$("#marcoEstudiante" + i).hide();
		       	}
		    }
		}
	}
					
	$(function() {
		$("#botonAgregar").click(function( event ) {		
			if(numEstudiante < 3){
				numEstudiante++;
	 			$("#marcoEstudiante"+ numEstudiante).show(); 			
			}
		});
	}); 	
				
});