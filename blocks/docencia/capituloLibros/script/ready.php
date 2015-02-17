<?php
// Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
// if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){
?>
        // Asociar el widget de validación al formulario
        $("#capituloLibros").validationEngine({
            promptPosition : "centerRight", 
            scroll: false,
            autoHidePrompt: true,
            autoHideDelay: 2000
        });

        $(function() {
            $("#capituloLibros").submit(function() {
                $resultado=$("#capituloLibros").validationEngine("validate");
                
                
                
                if ($resultado) {
                
                    return true;
                }
                return false;
            });
        });
   
        
        $("#capituloLibros").change(function(){
            $("#detalleDocencia").val('');
            var camposForm = [ "titulocapitulo", "titulolibro", "tipo_libro", "codigo_numeracion", "editorial", "anio_libro", "volumen","num_autores_cap", "num_autores_universidad", "num_autores_libro", "num_autores_libro_universidad", "numEvaluadores", "numeActa", "fechaActa", "numeCaso", "puntaje"];
            
            var texto = '';
            $("#capituloLibros").find(':input').each(function() {
                
                var elemento= this;               
                
                if($.inArray(elemento.id,camposForm) !== -1)
                {                
                    
                    if(elemento.value != '')
                    {
                        if(elemento.id == 'tipo_libro')
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

        $("#tipo_libro").select2();  
        $("#numEvaluadores").select2();
        $("#uniEvaluador1").select2();
        $("#uniEvaluador2").select2();
        $("#uniEvaluador3").select2();
           
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

}
});
        
        
        
        
          $('#anio_libro').datepicker( {   
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
        var fechamin=new Date(year, 1, 1);
        $('#fechaActa').removeAttr('disabled');
        $('#fechaActa').val(' ');
        $('input#fechaActa').datepicker('option', 'minDate', fechamin);
        
         
      		}      			
      	     		
		});
		
		$("#anio_libro").focus(function () {
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
        $("#identificacion").attr('disabled','disabled');
        
        
                
        // Validacion para el numero de Evaluadores
          
         $( "#numEvaluadores" ).change(function() {
            switch($("#numEvaluadores").val())
            {
                case '1':
                    $("#divEv2").css('display','none');
                    $("#divEv3").css('display','none');
                    
      
                                       
   
                break;
            
                case '2':
                    
                    $("#divEv2").css('display','block');
                    $("#divEv3").css('display','none');
                                        
        
                   
                    
                break;
                case '3':
                
                    $("#divEv2").css('display','block');
                    $("#divEv3").css('display','block');
                    
                                        
                                     
                break;
            }
          });
        
        
        $( "#puntaje" ).change(function() {
        
        
        switch($("#tipo_libro").val())
        
        {
        
        
        	 case '1':
            
              $("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all  validate[required, custom[number],min[0.1],max[20]]");
                break;
            
             case '2':
                    
             $("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all  validate[required, custom[number],min[0.1],max[15]]");
                    
                break;
             case '3':
             $("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all  validate[required, custom[number],min[0.1],max[15]]");

             
             
                break;
        
        
           default:
             $("#puntaje").val('');

             
             
                break;
        
        
        
        
        
        
        
        }
        
        });
        
                $( "#tipo_libro" ).change(function() {
                
                
                $("#puntaje").val('');
                
                
                
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
        
        
     


