//Document Ready es necesario para que cargue correctamente.
$(document).ready(function(){

<?php
$numeroEvaluadores = 0;
for($i=1; $i<=3; $i++){
	if(isset($_REQUEST['documentoEvaluador' . $i]) && $_REQUEST['documentoEvaluador' . $i] != ''){
		$numeroEvaluadores++;
	}
}
?>
var evaluadoRequerido = <?php echo $numeroEvaluadores;?>;
var evaluador = 3;
var numEvaluadores = evaluadoRequerido;
var indice = 0;

for(var i = evaluador; i > evaluadoRequerido; i--){
	$("#marcoEvaluador" + i).hide();
}

String.prototype.insertAt=function(index, string) { 
  return this.substr(0, index) + string + this.substr(index);
}
var idDatosEvaluadores = [
   <?php for($i=1; $i<=3; $i++):?> 
	 '<?php echo $this->campoSeguro('documentoEvaluador'.$i)?>',
	 '<?php echo $this->campoSeguro('nombreEvaluador'.$i)?>',
	 '<?php echo $this->campoSeguro('puntajeSugeridoEvaluador'.$i)?>',
   <?php endfor; ?>
];
//Agrega required a todos los campos de los evaluadores
$.each(idDatosEvaluadores,function (i,v){
	var obj = $("#"+v);
	if(obj.length>0){
		var clases = obj.attr('class').split(' ');
		var claseValidate = $.grep(clases,function(v,i){return v.indexOf('validate')>-1})[0];
		obj.removeClass(claseValidate);
		claseValidate = claseValidate.insertAt(claseValidate.indexOf("[")+1,'required,');
		obj.addClass(claseValidate);
	}
});


$("#botonEliminarEvaluador1").click(function( event ) { eliminarEvaluador1(); });
$("#botonEliminarEvaluador2").click(function( event ) { eliminarEvaluador2(); });
$("#botonEliminarEvaluador3").click(function( event ) { eliminarEvaluador3(); });

function eliminarEvaluador1()  {
	confirmar=confirm("¿Desea eliminar a este evaluador?");  
    if (confirmar){
       	<?php for($i=1; $i<=3; $i++):?>      
        	$('#<?php echo $this->campoSeguro('documentoEvaluador'.$i)?>').val($('#<?php echo $this->campoSeguro('documentoEvaluador'.($i+1))?>').val());
       		$('#<?php echo $this->campoSeguro('nombreEvaluador'.$i)?>').val($('#<?php echo $this->campoSeguro('nombreEvaluador'.($i+1))?>').val());
       		$('#<?php echo $this->campoSeguro('entidadCertificadora'.$i)?>').select2('val',$('#<?php echo $this->campoSeguro('entidadCertificadora'.($i+1))?>').val());
       		$('#<?php echo $this->campoSeguro('puntajeSugeridoEvaluador'.$i)?>').val($('#<?php echo $this->campoSeguro('puntajeSugeridoEvaluador'.($i+1))?>').val());
            <?php if($i==3): ?>
           	   	$('#<?php echo $this->campoSeguro('documentoEvaluador'.$i)?>').val("");
           		$('#<?php echo $this->campoSeguro('nombreEvaluador'.$i)?>').val("");
           		$('#<?php echo $this->campoSeguro('entidadCertificadora'.$i)?>').select2('val', '');
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
	confirmar=confirm("¿Desea eliminar a este evaluador?");  
    if (confirmar){
       	<?php for($i=2; $i<=3; $i++):?>        	 
        	$('#<?php echo $this->campoSeguro('documentoEvaluador'.$i)?>').val($('#<?php echo $this->campoSeguro('documentoEvaluador'.($i+1))?>').val());
       		$('#<?php echo $this->campoSeguro('nombreEvaluador'.$i)?>').val($('#<?php echo $this->campoSeguro('nombreEvaluador'.($i+1))?>').val());
       		$('#<?php echo $this->campoSeguro('entidadCertificadora'.$i)?>').select2('val',$('#<?php echo $this->campoSeguro('entidadCertificadora'.($i+1))?>').val());
       		$('#<?php echo $this->campoSeguro('puntajeSugeridoEvaluador'.$i)?>').val($('#<?php echo $this->campoSeguro('puntajeSugeridoEvaluador'.($i+1))?>').val());
            <?php if($i==3): ?>
           	   	$('#<?php echo $this->campoSeguro('documentoEvaluador'.$i)?>').val("");
           		$('#<?php echo $this->campoSeguro('nombreEvaluador'.$i)?>').val("");
           		$('#<?php echo $this->campoSeguro('entidadCertificadora'.$i)?>').select2('val', '');
           		$('#<?php echo $this->campoSeguro('puntajeSugeridoEvaluador'.$i)?>').val("");
            <?php endif; ?>
        <?php endfor; ?>
           
		numEvaluadores--;
    }	
	for(var i = evaluador; i > numEvaluadores; i--){
   		$("#marcoEvaluador" + i).hide();
   	}    
}

function eliminarEvaluador3()  {
	confirmar=confirm("¿Desea eliminar a este evaluador?");  
    if (confirmar){
       	<?php for($i=3; $i<=3; $i++):?>        	 
            <?php if($i==3): ?>
           	   	$('#<?php echo $this->campoSeguro('documentoEvaluador'.$i)?>').val("");
           		$('#<?php echo $this->campoSeguro('nombreEvaluador'.$i)?>').val("");
           		$('#<?php echo $this->campoSeguro('entidadCertificadora'.$i)?>').select2('val', '');
           		$('#<?php echo $this->campoSeguro('puntajeSugeridoEvaluador'.$i)?>').val("");
            <?php endif; ?>
        <?php endfor; ?>
           
		numEvaluadores--;
			
		for(var i = evaluador; i > numEvaluadores; i--){
       		$("#marcoEvaluador" + i).hide();
       	}
    }
}
				
$("#botonAgregarEvaluador").click(function( event ) {		
	if(numEvaluadores < 3){
		numEvaluadores++;
		$("#marcoEvaluador"+ numEvaluadores).show(); 			
	}
});
		
});
