<?php 
//Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
//if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){

?>
        // Asociar el widget de validación al formulario
        $("#publImprUnivDocente").validationEngine({
            promptPosition : "centerRight", 
            scroll: false,
            autoHidePrompt: true,
            autoHideDelay: 2000
        });

        $(function() {
            $("#publImprUnivDocente").submit(function() {
                $resultado=$("#ponenciaDocente").validationEngine("validate");
                
                if ($resultado) {
                
                    return true;
                }
                return false;
            });
        });



		
		    $("#codigoNumeracion").change(function(event) {
		    
		    			
 			if ($("#codigoNumeracion").val()== 2){
 	
 	          $("#Trevista").css('display','none');
 	      		$("#Tlibro").css('display','block');
 	
     
    
     		  } else if ($("#codigoNumeracion").val()== 1){
     		        	
     		  
     		  $("#Tlibro").css('display','none');
 	            $("#Trevista").css('display','block');
 	      		
     		         			
       
      		}else{
      		
      		
      		  		  $("#Tlibro").css('display','none');
 	            $("#Trevista").css('display','none');
 	      		
      		
      		
      		}
				});
        
        
        
        $('#fechaPublicacion').datepicker({
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
var lockDate = new Date($('#fechaPublicacion').datepicker('getDate'));
//lockDate.setDate(lockDate.getDate() + 1);
$('input#fechaActa').datepicker('option', 'minDate', lockDate);
$('input#anioR').datepicker('option', 'minDate', lockDate);
$('input#anioL').datepicker('option', 'minDate', lockDate);
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
$('input#fechaPublicacion').datepicker('option', 'maxDate', lockDate);
$('input#anioR').datepicker('option', 'maxDate', lockDate);
$('input#anioL').datepicker('option', 'maxDate', lockDate);
}
});
        
        
        
        
          $('#anioR').datepicker( {   
    	changeYear: true,
    	minDate:  $('#fechaPublicacion').datepicker('getDate'),
    	maxDate: $('#fechaActa').datepicker('getDate'),
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
    	minDate:  $('#fechaPublicacion').datepicker('getDate'),
     	maxDate: $('#fechaActa').datepicker('getDate'),
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
        
        
        
        
        	
        
        $("#codigoNumeracion").select2();
        $("#categoria_revista").select2();
        
        
         $("#docente").select2();
        $("#facultad").select2();
        $("#proyecto").select2();
        $("#categoria").select2();
        
        $('#tablaTitulos').dataTable( {
                "sPaginationType": "full_numbers"
        } );
        
                       
        $(function() {
		$(document).tooltip({
                    position: {
                      my: "left top",
                      at: "right+5 top-5"
                    }
                  });
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
        
        
     


