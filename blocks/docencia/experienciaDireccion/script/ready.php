<?php
// Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
// if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){
?>
        // Asociar el widget de validación al formulario
        $("#experienciaDireccion").validationEngine({
            promptPosition : "centerRight", 
            scroll: false,
            autoHidePrompt: true,
            autoHideDelay: 2000
        });

        $(function() {
            $("#experienciaDireccion").submit(function() {
                $resultado=$("#experienciaDireccion").validationEngine("validate");
                $('#duracion').removeAttr('disabled');
                $('#fechaFinal').removeAttr('disabled');
                $('#fechaActa').removeAttr('disabled');
                if ($resultado) {
                
                    return true;
                }
                return false;
            });
        });
   
        $("#experienciaDireccion").change(function(){
            $("#detalleDocencia").val('');
            var camposForm = [ "entidad", "otraEntidad", "tipo_entidad", "numeHoras", "fechaInicio", "fechaFinal", "duracion", "numeActa", "fechaActa", "numeCaso", "puntaje" ];
            
            var texto = '';
            $("#experienciaDireccion").find(':input').each(function() {
                
                var elemento= this;               
                
                if($.inArray(elemento.id,camposForm) !== -1)
                {                
                    
                    if(elemento.value != '')
                    {
                        if(elemento.id == 'entidad' || elemento.id == 'tipo_entidad')
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
        
        /*
   
          $("#duracion").change(function(event) {		
            
            
            if($('#fechaFinal').val()!=''&&$('#fechaInicio').val()!=''){ 
            var lockDateFin = new Date($('#fechaFinal').datepicker('getDate'));
			var lockDateInicial = new Date($('#fechaInicio').datepicker('getDate'));
			var anio_fin=lockDateFin.getFullYear();
			var anio_inicial=lockDateInicial.getFullYear();
			duracion = new Date(lockDateFin -lockDateInicial);
 			var days = duracion/1000/60/60/24;
			$('#duracion').val(days);
          }else{
          
          $("#duracion").val('');
          
          
          }
		});
   
                */
   
                   $("#entidad").ready(function() {		
		            //$('#duracion').attr('disabled','disabled');
					if($("#entidad").val()!=''&&$("#entidad").val()!='-1'){
							                 			
						$("#otraEntidad").attr('disabled','disabled');						
					}
		});       
        
        
        $("#entidad").change(function() {		
		
					if($("#entidad").val()!= -1 && $("#entidad").val()!=''){
						$("#otraEntidad").val('');
						$("#otraEntidad").attr('disabled','disabled');						
					}else {		
								
							$("#otraEntidad").removeAttr('disabled');
					}		
		});
		
		
		
				
		$("#otraEntidad").change(function() {		
		
					if($("#otraEntidad").val()!=''){
						$("#entidad").val('-1');
						$("#seleccionEntidad").css('display','none');						
					}else if($("#otraEntidad").val()=='' ){					
							$("#seleccionEntidad").css('display','block');
					}		
		});


        
              $('#fechaInicio').datepicker({
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
var lockDate = new Date($('#fechaInicio').datepicker('getDate'));
var ani=parseInt(lockDate.getFullYear());
var anios= parseInt($('#duracion').val());
 var anio_max=new Date(anios+ani,lockDate.getMonth(),lockDate.getDate());
//lockDate.setDate(lockDate.getDate() + 1);
$('#fechaFinal').removeAttr('disabled');
$('#fechaFinal').val('');
$('input#fechaFinal').datepicker('option', 'minDate', lockDate);
$('input#fechaActa').datepicker('option', 'minDate', lockDate);

$('#puntaje').val('');
$('#duracion').val('');
}
});
        
              $('#fechaFinal').datepicker({
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
var lockDateFin = new Date($('#fechaFinal').datepicker('getDate'));
var lockDateInicial = new Date($('#fechaInicio').datepicker('getDate'));
/*
var anio_fin=lockDateFin.getFullYear();
var anio_inicial=lockDateInicial.getFullYear();
duracion = new Date(lockDateFin -lockDateInicial);
 var days = duracion/1000/60/60/24;
$('#duracion').val(days);
*/
$('#fechaActa').removeAttr('disabled');
$('#puntaje').val('');
$('input#fechaActa').datepicker('option', 'minDate', lockDateFin);


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
var lockDate1 = new Date($('#fechaInicio').datepicker('getDate'));
//lockDate.setDate(lockDate.getDate() + 1);


  

}
});
        
        
        
        

        
        $("#facultad").select2();
        $("#proyecto").select2();
        $("#entidad").select2();
        $("#tipo_entidad").select2();
        
        //$("#docente").select2();
        //$("#identificacionFinalConsulta").select2();
        //$("#identificacion").attr('disabled','disabled');
        
                

        /*
        
        $("#puntaje").change(function(event) {

        
        var lockDateFin = new Date($('#fechaFinal').datepicker('getDate'));
		var lockDateInicial = new Date($('#fechaInicio').datepicker('getDate'));

		var anio_fin=lockDateFin.getFullYear();
		var anio_inicial=lockDateInicial.getFullYear();

		duracion = new Date(lockDateFin -lockDateInicial);
 		var dias = duracion/1000/60/60/24;
        var puntaje = ((parseInt(dias)*4)/365);
        
        
        if(puntaje<0.1){
        
        puntaje = (0.1);
        
        }
        
        
        $("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all  validate[required, custom[number],min[0.1],max["+puntaje+"]]");
         });
        */
         
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
        
        
     


