<script type='text/javascript'>

<? php $numeroEvaluadores = 1; ?>
var evaluadoRequerido = 1;
var numeroEvaluador = 3;
var numEvaluadores = evaluadoRequerido;
var indice = 0;

for(var i = numeroEvaluador; i > evaluadoRequerido; i--){
	$("#marcoEvaluador" + i).hide();
}

$('#<?php echo $this->campoSeguro('docente')?>')




$(function() {
	
	
	$("#botonEliminarEvaluador1").click(function( event ) {
		confirmar=confirm("¿Desea eliminar a esté evaluador?");  
        if (confirmar){
                			
        	eliminado = 0;													           			
//            eliminarEvaluador();
        	<?php $a = 0; ?>
        	for(var i=1; i<=3; i++){     	 
        		<?php $a++; ?>
	        	$('#<?php echo $this->campoSeguro('documentoEvaluador'.$a)?>').val($('#<?php echo $this->campoSeguro('documentoEvaluador'.($a+1))?>').val());
	       		$('#<?php echo $this->campoSeguro('nombreEvaluador'.$a)?>').val($('#<?php echo $this->campoSeguro('nombreEvaluador'.($a+1))?>').val());
	       		$('#<?php echo $this->campoSeguro('entidadEvaluador'.$a)?>').val($('#<?php echo $this->campoSeguro('entidadEvaluador'.($a+1))?>').val());
	       		$('#<?php echo $this->campoSeguro('puntajeSugeridoEvaluador'.$a)?>').val($('#<?php echo $this->campoSeguro('puntajeSugeridoEvaluador'.($a+1))?>').val());

               if(i==3){
            	   	$('#<?php echo $this->campoSeguro('documentoEvaluador'.$a)?>').val("");
               		$('#<?php echo $this->campoSeguro('nombreEvaluador'.$a)?>').val("");
               		$('#<?php echo $this->campoSeguro('entidadEvaluador'.$a)?>').val("");
               		$('#<?php echo $this->campoSeguro('puntajeSugeridoEvaluador'.$a)?>').val("");
        	}
              
	}    
           
          

			if(numEvaluadores==1){
				$("#marcoEvaluador1").hide();
			}else if(numEvaluadores==2){
				$("#marcoEvaluador2").hide();
				eliminar = 1;
			}else if(numEvaluadores==3){
				$("#marcoEvaluador3").hide();
			}	
			numEvaluadores--;					
                			    
         } else{      	
                		}					
	});

});

				$(function() {
					$("#botonEliminarEvaluador2").click(function( event ) {
						confirmar=confirm("¿Desea eliminar a esté evaluador?");  
                		if (confirmar){

                			eliminado = 1;
//                			eliminarEvaluador();			

							$("#idEvaluador2").val($("#idEvaluador3").val());
							$("#nomEvaluador2").val($("#nomEvaluador3").val());
							$("#uniEvaluador2").val($("#uniEvaluador3").val());
							$("#puntEvaluador2").val($("#puntEvaluador3").val());

							$("#idEvaluador3").val("");
							$("#nomEvaluador3").val("");
							$("#uniEvaluador3").val(-1);
							$("#puntEvaluador3").val("");
							
                			if(numEvaluadores==2){
                    			$("#marcoEvaluador2").hide();
                			}else if(numEvaluadores==3){
                				$("#marcoEvaluador3").hide();
                    		}
               			
                			numEvaluadores--;    
                			
                			    
                		} else{
                		                	
                		}					
					});
				});

				$(function() {					
					$("#botonEliminarEvaluador3").click(function( event ) {										 	
						confirmar=confirm("¿Desea eliminar a esté evaluador?");  
                		if (confirmar){                        		

                			eliminado = 2;
//                			eliminarEvaluador();  
                			
                			$("#idEvaluador3").val("");
							$("#nomEvaluador3").val("");
							$("#uniEvaluador3").val(-1);
							$("#puntEvaluador3").val("");
							        		            			              		                    		
                			$("#marcoEvaluador3").hide();
                			
                			numEvaluadores--;     
                			  
                		} else{
                		                	
                		}					
					});
				});
				
			
				
				$(function() {
 			    	$("#botonAgregarEvaluador").click(function( event ) {		
 			    		if(numEvaluadores <= 3){
 			    			numEvaluadores++;
 			    			$("#marcoEvaluador"+ numEvaluadores).show();
	 			    	}
 					});
 				}); 	
				
				
</script>