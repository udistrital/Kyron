<?php

?>

// Asociar el widget de validación al formulario
              $("#funcionarioElemento").validationEngine({
            promptPosition : "topLeft:180,10", 
            scroll: false,
            autoHidePrompt: true,
            autoHideDelay: 2000
	         });
	
        
        
        
        
        
        $(function() {
            $("#funcionarioElemento").submit(function() {
                $resultado=$("#funcionarioElemento").validationEngine("validate");
                   
                   
                   
                if ($resultado) {
                
                    return true;
                }
                return false;
            });
        });

         $(function() {
         
         
    $( "#ventanaEmergente" ).dialog({
						  height: 470,
						  width: 900,
						  title: "Información Levantamiento Físico",
						  autoOpen: false,
						  
				});
				
				
				$("#abrir").button().click(function () {
							$("#ventanaEmergente").dialog("open");
						});

				
				
  });
        
        


    $('#<?php echo $this->campoSeguro('botonAprobar')?>').attr('disabled','disabled');
             
 
$('#<?php echo $this->campoSeguro('funcionario')?>').width(500);                 	 
 $("#<?php echo $this->campoSeguro('funcionario')?>").select2({
             	 placeholder: "Ingrese Mínimo 3 Caracteres de Búsqueda",
              	 minimumInputLength: 3,
              	 });

              	 
              	            	            	 
              	               	 
              	 
              	 $("#<?php echo $this->campoSeguro('tipo_poliza')?>").select2();
 $("#<?php echo $this->campoSeguro('nivel')?>").select2();
 $("#<?php echo $this->campoSeguro('tipo_registro')?>").select2();
 
 
 $("#<?php echo $this->campoSeguro('sede')?>").select2();
 
 $('#<?php echo $this->campoSeguro('ubicacion')?>').width(500);     
 $("#<?php echo $this->campoSeguro('ubicacion')?>").select2();
 
 $("#<?php echo $this->campoSeguro('dependencia')?>").select2();
 
 
 $("#<?php echo $this->campoSeguro('tipo_bien')?>").select2();
 $("#<?php echo $this->campoSeguro('iva')?>").select2();
 $("#<?php echo $this->campoSeguro('bodega')?>").select2();
 
                  
     
     $( "#<?php echo $this->campoSeguro('tipo_registro')?>" ).change(function() {
        
            switch($("#<?php echo $this->campoSeguro('tipo_registro')?>").val())
            {
                           
                case '1':
                    
                   
                    $("#<?php echo $this->campoSeguro('cargar_elemento')?>").css('display','block');
                    $("#<?php echo $this->campoSeguro('cargue_elementos')?>").css('display','none');

                   

                break;
                
                
                       case '2':
                    
                    $("#<?php echo $this->campoSeguro('cargar_elemento')?>").css('display','none');
                    $("#<?php echo $this->campoSeguro('cargue_elementos')?>").css('display','block');
       
                break;
                

                default:
                
                    $("#<?php echo $this->campoSeguro('cargar_elemento')?>").css('display','block');
                    $("#<?php echo $this->campoSeguro('cargue_elementos')?>").css('display','none');
                   
                   break;
                
                
             }
          });  
        
		  
     $( "#<?php echo $this->campoSeguro('tipo_poliza')?>" ).change(function() {
        
            switch($("#<?php echo $this->campoSeguro('tipo_poliza')?>").val())
            {
                           
                case '0':
                    
                   
                    $("#<?php echo $this->campoSeguro('fechas_polizas')?>").css('display','none');
                   

                   

                break;
                
                
                case '1':
                    
                  $("#<?php echo $this->campoSeguro('fechas_polizas')?>").css('display','block');
       
                break;
                

                default:
                
                $("#<?php echo $this->campoSeguro('fechas_polizas')?>").css('display','none');
                   
                   break;
                
                
             }
          });  
	
	
	
	     $( "#<?php echo $this->campoSeguro('tipo_bien')?>" ).change(function() {
        
            switch($("#<?php echo $this->campoSeguro('tipo_bien')?>").val())
            {
                           
                case '2':
                    
                   
                    $("#<?php echo $this->campoSeguro('devolutivo')?>").css('display','none');
                    $("#<?php echo $this->campoSeguro('consumo_controlado')?>").css('display','block');
                   

                   

                break;
                
                
                case '3':
                    
                  $("#<?php echo $this->campoSeguro('devolutivo')?>").css('display','block');
                  $("#<?php echo $this->campoSeguro('consumo_controlado')?>").css('display','none');
       
                break;
                

                default:
                
                $("#<?php echo $this->campoSeguro('devolutivo')?>").css('display','none');
                $("#<?php echo $this->campoSeguro('consumo_controlado')?>").css('display','none');   
                   break;
                
                
             }
          });  
	

                
                
 
        
                        
        $('#<?php echo $this->campoSeguro('fecha_inicio')?>').datepicker({
		dateFormat: 'yy-mm-dd',
		maxDate: 0,
		changeYear: true,
		changeMonth: true,
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
		    'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		    monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
		    dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
		    dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		    onSelect: function(dateText, inst) {
			var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_inicio')?>').datepicker('getDate'));
			$('input#<?php echo $this->campoSeguro('fecha_final')?>').datepicker('option', 'minDate', lockDate);
			},
			onClose: function() { 
		 	    if ($('input#<?php echo $this->campoSeguro('fecha_inicio')?>').val()!='')
                    {
                        $('#<?php echo $this->campoSeguro('fecha_final')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
                }else {
                        $('#<?php echo $this->campoSeguro('fecha_final')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
                    }
			  }
			
			
		});
              $('#<?php echo $this->campoSeguro('fecha_final')?>').datepicker({
		dateFormat: 'yy-mm-dd',
		maxDate: 0,
		changeYear: true,
		changeMonth: true,
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
		    'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		    monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
		    dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
		    dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		    onSelect: function(dateText, inst) {
			var lockDate = new Date($('#<?php echo $this->campoSeguro('fecha_final')?>').datepicker('getDate'));
			$('input#<?php echo $this->campoSeguro('fecha_inicio')?>').datepicker('option', 'maxDate', lockDate);
			 },
			 onClose: function() { 
		 	    if ($('input#<?php echo $this->campoSeguro('fecha_final')?>').val()!='')
                    {
                        $('#<?php echo $this->campoSeguro('fecha_inicio')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
                }else {
                        $('#<?php echo $this->campoSeguro('fecha_inicio')?>').attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
                    }
			  }
			
	   });
	   