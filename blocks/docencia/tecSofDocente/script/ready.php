<?php 
//Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
//if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){

?>
        // Asociar el widget de validación al formulario
        $("#tecSofDocente").validationEngine({
            promptPosition : "centerRight", 
            scroll: false,
            autoHidePrompt: true,
            autoHideDelay: 2000
        });
        

        $(function() {
            $("#tecSofDocente").submit(function() {
                $resultado=$("#tecSofDocente").validationEngine("validate");
                
                if ($resultado) {
                
                    return true;
                }
                return false;
            });
        });
        
        $("#tecSofDocente").change(function(){
            $("#detalleDocencia").val('');
            var camposForm = [ "tipo", "numeCertificado", "numEvaluadores", "fechaPr", "numeActa", "fechaActa", "numeCaso", "puntaje" ];
            
            var texto = '';
            $("#tecSofDocente").find(':input').each(function() {
                
                var elemento= this;               
                
                if($.inArray(elemento.id,camposForm) !== -1)
                {                
                    
                    if(elemento.value != '')
                    {
                        if(elemento.id == 'tipo')
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
        

        
        $("#tipo").select2();
        $("#numEvaluadores").select2();
        $("#univEva1").select2();
        $("#univEva2").select2();
        $("#univEva3").select2();
         
         
    $( "#numEvaluadores" ).change(function() {
            switch($("#numEvaluadores").val())
            {
     
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
          $("#tipo").change(function(){
          
   
             $("#puntaje").val('');
  
          
          });
          
          $("#puntaje").change(function(){
          
          switch($("#tipo").val())
        
    	   {
        
        
        	 case '1':
            
              $("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all  validate[required, custom[number],min[0.1],max[15]]");
                break;
            
             case '2':
                    
             $("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all  validate[required, custom[number],min[0.1],max[8]]");
                    
                break;
             case '3':
             $("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all  validate[required, custom[number],min[0.1],max[15]]");

                break;
        
        
           default:
             $("#puntaje").val('');
             break;

     	   }

          
          });
          
          
          
        $('#fechaPr').datepicker({
dateFormat: 'yy-mm-dd',
maxDate: 0,
minDate:'2004-01-01',
changeYear: true,
changeMonth: true,
monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
	'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
	monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
	dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
	dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
	dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'], 
	onSelect: function(dateText, inst) {
var lockDate = new Date($('#fechaPr').datepicker('getDate'));
$('input#fechaActa').datepicker('option', 'minDate', lockDate);
}
        
        });
          
          
                  

        $('#fechaActa').datepicker({
        dateFormat: 'yy-mm-dd',
        maxDate: 0,
        changeYear: true,
        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
	'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
	monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
	dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
	dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
	dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa']
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
        
        
     


