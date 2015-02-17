<?php
// Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
// if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){
?>
        // Asociar el widget de validación al formulario
        $("#direccionTrabajos").validationEngine({
            promptPosition : "centerRight", 
            scroll: false,
            autoHidePrompt: true,
            autoHideDelay: 2000
        });

        $(function() {
            $("#direccionTrabajos").submit(function() {
                $resultado=$("#direccionTrabajos").validationEngine("validate");
                
                if ($resultado) {
                
                    return true;
                }
                return false;
            });
        });
        
        
        $("#direccionTrabajos").change(function(){
            $("#detalleDocencia").val('');
            var camposForm = [ "tituloTrabajo", "anio_direccion", "tipoTrabajo", "categoriaTrabajo", "numeActa", "fechaActa", "numeCaso","puntaje"];
            
            var texto = '';
            $("#direccionTrabajos").find(':input').each(function() {
                
                var elemento= this;               
                
                if($.inArray(elemento.id,camposForm) !== -1)
                {                
                    
                    if(elemento.value != '')
                    {
                        if(elemento.id == 'tipoTrabajo' || elemento.id == 'categoriaTrabajo')
                        {
                            texto += $("#" + elemento.id + " option:selected").text() + ", ";
                        }else
                        {
                            texto += elemento.value + ", ";
                        }                        
                    }
                }                
                
           });
           $("#detalleDocencia").val(texto);
        });
   
   
   
             $("#puntaje").ready(function(event) 
                {
   
   $("#autor_adicio1").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, minSize[6],maxSize[2000]]");
   $("#autor_adicio2").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, minSize[6],maxSize[2000]]");
   $("#autor_adicio3").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, minSize[6],maxSize[2000]]");
   
   
   
                   if ($("#tipoTrabajo").val()== 3 || $("#tipoTrabajo").val()== 4)
                    {
               			 $("#puntaje").attr('disabled','disabled');
                    }
                
                });
   
          
        
             $("#puntaje").change(function(event)  
                {
 		    if ($("#tipoTrabajo").val()== 1)
                    {
                        if($("#categoriaTrabajo").val()== 1){
                           $("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[20]]");
                   
                        }else if($("#categoriaTrabajo").val()== 2){
                            $("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[32]]");
                        
                   
                        }else if($("#categoriaTrabajo").val()== 3){
                            $("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[36]]");
                        
                   
                        }else{
                        $("#puntaje").val('');
                        
                        }
                        
             
                    }else if ($("#tipoTrabajo").val()== 2)
                        {
                         if($("#categoriaTrabajo").val()== 1){
                           $("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[62]]");
                   
                        }else if($("#categoriaTrabajo").val()== 2){
                            $("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[70]]");
                        
                   
                        }else if($("#categoriaTrabajo").val()== 3){
                            $("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[72]]");
                        
                   
                        }else{
                        $("#puntaje").val('');
                        
                        }
                         
                        }else if ($("#tipoTrabajo").val()== 3 || $("#tipoTrabajo").val()== 4)
                        {
                           $("#puntaje").val(''); 
                                                  
       
                        }else{
                            $("#puntaje").val(''); 
                     
                        }
            });
            
                  $("#tipoTrabajo").change(function(event) 
                {
                     if ($("#tipoTrabajo").val()== 3 || $("#tipoTrabajo").val()== 4)
                        {
                        
                           $("#puntaje").attr('disabled','disabled');
                                                  
         
                        }else{
                        
                         $("#puntaje").removeAttr('disabled');
                        
                        
                        }
                
                
                 		$("#puntaje").val(''); 
                 		
                });
                
                
                        $("#categoriaTrabajo").change(function(event) 
               				 {
               
                
                
                 		$("#puntaje").val(''); 
                 		
             		   });
        
        
 
 
        
      $('#fechaActa').datepicker({
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
var lockDate = new Date($('#fechaActa').datepicker('getDate'));
//lockDate.setDate(lockDate.getDate() + 1);
$('input#anio_direccion').datepicker('option', 'maxDate', lockDate);
}
});
        
        
        
        
          $('#anio_direccion').datepicker( {   
    	changeYear: true,
    	maxDate:0,
      	monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
	'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
   		 showButtonPanel: true,
    	dateFormat: 'yy',
    	onClose: function(dateText, inst) {
    	//lockDate.setDate(lockDate.getDate() + 1);
        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
        $(this).datepicker('setDate', new Date(year, 1, 1));
        var strDate ="01/01"+"/"+year;
      		}      			
      	     		
		});
		
		$("#anio_direccion").focus(function () {
    	$(".ui-datepicker-calendar").hide();
    	$("#ui-datepicker-div").position({
        my: "center top",
        at: "center bottom",
        of: $(this)
    		});
		});
        
        $("#facultad").select2();
        $("#proyecto").select2();
        $("#tipoTrabajo").select2();
        $("#categoriaTrabajo").select2();
        $("#numAuto").select2();
        //$("#docente").select2();
        //$("#identificacionFinalConsulta").select2();
        //$("#identificacion").attr('disabled','disabled');
        
        
                
        // Validacion para el numero de autores
          
        $( "#numAuto" ).change(function() {
            switch($("#numAuto").val())
            {
                case '1':
                    $("#divAu2").css('display','none');
                    $("#divAu3").css('display','none');

                    
   
   $("#autor_adicio2").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, minSize[6],maxSize[2000]]");
   $("#autor_adicio3").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, minSize[6],maxSize[2000]]");
                    
                    $("#autor_adicio2").val(' ');
                    $("#autor_adicio3").val(' ');
                    
              
                    
                break;
            
                case '2':
                    
                    $("#divAu2").css('display','block');
                    $("#divAu3").css('display','none');
                    $("#autor_adicio3").val(' ');
                    
                    $("#autor_adicio3").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, minSize[6],maxSize[2000]]");
                    
                break;
                case '3':
                    $("#divAu2").css('display','block');
                    $("#divAu3").css('display','block');
                                  
                    $("#autor_adicio3").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, minSize[6],maxSize[2000]]");                    
                    
                break;
            }
          });
        
        
        
        
                
        
        
        $('#tablaTitulos').dataTable( {
                "sPaginationType": "full_numbers"
        } );
        
                       
        $(function() {
		$(document).tooltip();
	});
	
	
	
	
	// Asociar el widget tabs a la división cuyo id es tabs
	$(function() {
		$("#tabs").tabs();
	}); 
        
        $(function() {
            $( "input[type=submit], button" )
              .button()
              .click(function( event ) {
                event.preventDefault();
              });
          });
        
        
     


