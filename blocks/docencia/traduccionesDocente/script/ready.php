<?php 
//Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
//if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){

?>
        // Asociar el widget de validación al formulario
        $("#traduccionesDocente").validationEngine({
            promptPosition : "centerRight", 
            scroll: false
        });

        $(function() {
            $("#traduccionesDocente").submit(function() {
                $resultado=$("#traduccionesDocente").validationEngine("validate");
                
                if ($resultado) {
                
                    return true;
                }
                return false;
            });
        });
        
        $("#traduccionesDocente").change(function(){
            $("#detalleDocencia").val('');
            var camposForm = [ "titulo_publicacion", "titulo_traduccion", "tipo_traducc", "revista", "num_revista", "volumen", "anioR", "tipo_revista", "nom_libro", "editorial", "anioL", "fechaTraducc", "numeActa", "fechaActa", "numeCaso", "puntaje" ];
            
            var texto = '';
            $("#traduccionesDocente").find(':input').each(function() {
                
                var elemento= this;               
                
                if($.inArray(elemento.id,camposForm) !== -1)
                {                
                    
                    if(elemento.value != '')
                    {
                        if(elemento.id == 'tipo_traducc')
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
        
	//$("#docente").select2();
        //$("#identificacionFinalConsulta").select2();        
         $("#tipo_revista").select2();        
        $("#tipo_traducc").select2();       
        
        

        
        
        
        
        
         $("#tipo_traducc").change(function(event) {
 			
 			if ($("#tipo_traducc").val()== 1){
 				
 	          $("#Trevista").css('display','none');
 	      		$("#Tlibro").css('display','block');
 	
     
    
     		  } else if ($("#tipo_traducc").val()== 2){
     		        		
     		        		$("#seleccionpais").css('display','none');
     		       		  $("#Tlibro").css('display','none');
 	                    $("#Trevista").css('display','block');
 	      		
     		         			
       
      		}else{
      		
      		
      		  		  $("#Tlibro").css('display','none');
 	            $("#Trevista").css('display','none');
 	      		
      		
      		
      		}
				});
				
				$('#fechaTraducc').datepicker({
dateFormat: 'yy-mm-dd',
maxDate: 0,
changeYear: true,
monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
	'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
	monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
	dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
	dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
	dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
onSelect: function(dateText, inst) {
var lockDate = new Date($('#fechaTraducc').datepicker('getDate'));
//lockDate.setDate(lockDate.getDate() + 1);
$('input#fechaActa').datepicker('option', 'minDate', lockDate);
}
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
$('input#fechaTraducc').datepicker('option', 'maxDate', lockDate);
}
});  
        $('#anioR').datepicker( {   
    	changeYear: true,
    	maxDate: 0,
    	monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
	'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
   		 showButtonPanel: true,
    	dateFormat: 'yy',
    	onClose: function(dateText, inst) {
        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
        $(this).datepicker('setDate', new Date(year, 1, 1));
        var strDate ="01/01"+"/"+year;
    		}
		});
		
		$("#anioR").focus(function () {
    	$(".ui-datepicker-calendar").hide();
    	$("#ui-datepicker-div").position({
        my: "center top",
        at: "center bottom",
        of: $(this)
    		});
		});
		
		$('#anioL').datepicker( {   
    	changeYear: true,
    	maxDate: 0,
    	monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
	'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
   		 showButtonPanel: true,
    	dateFormat: 'yy',
    	onClose: function(dateText, inst) {
        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
        $(this).datepicker('setDate', new Date(year, 1, 1));
        var strDate ="01/01"+"/"+year;
    		}
		});
		
		$("#anioL").focus(function () {
    	$(".ui-datepicker-calendar").hide();
    	$("#ui-datepicker-div").position({
        my: "center top",
        at: "center bottom",
        of: $(this)
    		});
		});
        
        $("#facultad").select2();
        $("#proyecto").select2();
        $("#categoria").select2();
        
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
        
        
     


