<?php
// Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
// if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){
?>
        // Asociar el widget de validación al formulario
        $("#obrasartisticasDocente").validationEngine({
            promptPosition : "centerRight", 
            scroll: false
        });

        $(function() {
            $("#obrasartisticasDocente").submit(function() {
                $resultado=$("#obrasartisticasDocente").validationEngine("validate");
                
                if ($resultado) {
                
                    return true;
                }
                return false;
            });
        });

           
   	
        $("#obrasartisticasDocente").change(function(){
            $("#detalleDocencia").val('');
            var camposForm = [ "tipo_obra_artistica", "titulo_obra", "certificada", "anio_obra", "contexto", "numeActa", "fechaActa", "numeCaso", "puntaje"];
            
            var texto = '';
            $("#obrasartisticasDocente").find(':input').each(function() {
                
                var elemento= this;               
                
                if($.inArray(elemento.id,camposForm) !== -1)
                {                
                    
                    if(elemento.value != '')
                    {
                        if(elemento.id == 'tipo_obra_artistica' || elemento.id == 'contexto')
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
   	
   				

   				
   				  $("#tipo_obra_artistica").change(function() {
		$("#puntaje").val("") ;

		
		});
		
		
		   				  $("#contexto").change(function() {
		$("#puntaje").val("") ;

		
		});
        
   				
        
        $("#puntaje").change(function() {
		
		if ($("#tipo_obra_artistica").val()== 1){
		
				if ($("#contexto").val()== 1){
		
							if($("#puntaje").val() <= 14){
								}else{
									
									$("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all  validate[required, custom[number],min[0.1],max[14]]");
									
								}
					
				}else if($("#contexto").val()== 2){
				
							if($("#puntaje").val() <= 20){
								}else{
									
									$("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[20]]");
									
									
								}			
				
				}else {
			$("#puntaje").val("");
 
		}
		} else if ($("#tipo_obra_artistica").val()== 2){
		
				if ($("#contexto").val()== 1){
		
							if($("#puntaje").val() <= 8){
								}else{

									
									$("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[8]]");
									
									
								}
					
				}else if($("#contexto").val()== 2){
				
							if($("#puntaje").val() <= 12){
								}else{
									
									
									$("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[12]]");
									
							
									
								}			
				
				}else {
			$("#puntaje").val("");
 
		}
				
		}  else if ($("#tipo_obra_artistica").val()== 3){
		
				if ($("#contexto").val()== 1){
		
							if($("#puntaje").val() <= 8){
								}else{
									 
									
									$("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[8]]");
										
								}
					
				}else if($("#contexto").val()== 2){
				
							if($("#puntaje").val() <= 14){
								}else{
									 
									$("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[14]]");
									
					
								}			
				
				}else {
			$("#puntaje").val("");
 
		       }
		}  else {
			$("#puntaje").val("");
 
		}
		
		
		});
        

        $("#tipo_obra_artistica").select2();
        $("#entidad").select2();
         $("#contexto").select2();
         //$("#docente").select2();
         //$("#identificacionFinalConsulta").select2();
        
     
        

        
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
$('input#anio_obra').datepicker('option', 'maxDate', lockDate);
}
});
        
        
        
        
          $('#anio_obra').datepicker( {   
    	changeYear: true,
       	
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
		
		$("#anio_obra").focus(function () {
    	$(".ui-datepicker-calendar").hide();
    	$("#ui-datepicker-div").position({
        my: "center top",
        at: "center bottom",
        of: $(this)
    		});
		});
        
     
        
 
        
        $("#facultad").select2();
        $("#proyecto").select2();
        
        
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
        
        
     


