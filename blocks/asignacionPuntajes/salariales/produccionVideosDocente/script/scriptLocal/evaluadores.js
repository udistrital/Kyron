$( document ).ready(function() {
	
	<?php 
			if(!isset($_REQUEST['numeroEvaluadores'])){
				$_REQUEST['numeroEvaluadores'] = 2;
			}
	?>;
		
	var evaluadorRequerido = 2;
	var evaluador = 3;
	var numevaluador = <?php echo $_REQUEST['numeroEvaluadores'];?>;
	var indice = 0;
	
	for(var i = evaluador; i > evaluadorRequerido; i--){
		$("#marcoEvaluador" + i).hide();
	}
	
	for(var i = 1; i<= numevaluador; i++){
		$("#marcoEvaluador" + i).show();
	}
	
	$("#botonEliminar1").click(function( event ) { eliminar1(); });
	$("#botonEliminar2").click(function( event ) { eliminar2(); });
	$("#botonEliminar3").click(function( event ) { eliminar3(); });
	
	function eliminar1()  {
		if(numevaluador == evaluadorRequerido){
			alert("Deben haber dos (2) Evaluadores");
	
		}else{
			confirmar=confirm("¿Desea eliminar a esté evaluador?");  
		    if (confirmar){
		       	<?php for($i=1; $i<=3; $i++):?>      
		       		$('#<?php echo $this->campoSeguro('nombreEvaluador'.$i)?>').val($('#<?php echo $this->campoSeguro('nombreEvaluador'.($i+1))?>').val());
		       		$('#<?php echo $this->campoSeguro('universidadEvaluador'.$i)?>').select2('val',$('#<?php echo $this->campoSeguro('universidadEvaluador'.($i+1))?>').val());
		       		$('#<?php echo $this->campoSeguro('puntajeEvaluador'.$i)?>').val($('#<?php echo $this->campoSeguro('puntajeEvaluador'.($i+1))?>').val());

		            <?php if($i==3): ?>
		           		$('#<?php echo $this->campoSeguro('nombreEvaluador'.$i)?>').val("");
		           		$('#<?php echo $this->campoSeguro('universidadEvaluador'.$i)?>').select2('val','-1');
		           		$('#<?php echo $this->campoSeguro('puntajeEvaluador'.$i)?>').val("");
		            <?php endif; ?>
		        <?php endfor; ?>
		           
				numevaluador--;
					
				for(var i = evaluador; i > numevaluador; i--){
		       		$("#marcoEvaluador" + i).hide();
		       	}
		    }
		}
	}
	
	function eliminar2()  {
		if(numevaluador == evaluadorRequerido){
			alert("Deben haber dos (2) Evaluadores");

		}else{
			confirmar=confirm("¿Desea eliminar a esté evaluador?");  
		    if (confirmar){
		       	<?php for($i=2; $i<=3; $i++):?>        	 
	       		$('#<?php echo $this->campoSeguro('nombreEvaluador'.$i)?>').val($('#<?php echo $this->campoSeguro('nombreEvaluador'.($i+1))?>').val());
	       		$('#<?php echo $this->campoSeguro('universidadEvaluador'.$i)?>').select2('val',$('#<?php echo $this->campoSeguro('universidadEvaluador'.($i+1))?>').val());
	       		$('#<?php echo $this->campoSeguro('puntajeEvaluador'.$i)?>').val($('#<?php echo $this->campoSeguro('puntajeEvaluador'.($i+1))?>').val());
		            <?php if($i==3): ?>
	           		$('#<?php echo $this->campoSeguro('nombreEvaluador'.$i)?>').val("");
	           		$('#<?php echo $this->campoSeguro('universidadEvaluador'.$i)?>').select2('val','-1');
	           		$('#<?php echo $this->campoSeguro('puntajeEvaluador'.$i)?>').val("");
		            <?php endif; ?>
		        <?php endfor; ?>
		           
				numevaluador--;
					
				for(var i = evaluador; i > numevaluador; i--){
		       		$("#marcoEvaluador" + i).hide();
		       	}
		    }
		}
	}
	
	function eliminar3()  {
		if(numevaluador == evaluadorRequerido){
		}else{
			confirmar=confirm("¿Desea eliminar a esté evaluador?");  
		    if (confirmar){
		       	<?php for($i=3; $i<=3; $i++):?>        	 
		            <?php if($i==3): ?>
	           		$('#<?php echo $this->campoSeguro('nombreEvaluador'.$i)?>').val("");
	           		$('#<?php echo $this->campoSeguro('universidadEvaluador'.$i)?>').select2('val','-1');
	           		$('#<?php echo $this->campoSeguro('puntajeEvaluador'.$i)?>').val("");
		            <?php endif; ?>
		        <?php endfor; ?>
		           
				numevaluador--;
					
				for(var i = evaluador; i > numevaluador; i--){
		       		$("#marcoEvaluador" + i).hide();
		       	}
		    }
		}
	}
					
	$(function() {
		$("#botonAgregar").click(function( event ) {		
			if(numevaluador < 3){
				numevaluador++;
	 			$("#marcoEvaluador"+ numevaluador).show(); 			
			}
		});
	}); 	
				
});

String.prototype.insertAt=function(index, string) { 
	  return this.substr(0, index) + string + this.substr(index);
	}

var idDatosevaluadores = [
                          <?php for($i=1; $i<=3; $i++):?> 
                       	 '<?php echo $this->campoSeguro('nombreEvaluador'.$i)?>',
                       	'<?php echo $this->campoSeguro('puntajeEvaluador'.$i)?>',
                          <?php endfor; ?>
                       ];
//Agrega required a todos los campos de los evaluadores
$.each(idDatosevaluadores,function (i,v){
	var obj = $("#"+v);
	if(obj.length>0){
		var clases = obj.attr('class').split(' ');
		var claseValidate = $.grep(clases,function(v,i){return v.indexOf('validate')>-1})[0];
		obj.removeClass(claseValidate);
		claseValidate = claseValidate.insertAt(claseValidate.indexOf("[")+1,'required,');
		obj.addClass(claseValidate);
	}
});