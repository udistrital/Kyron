<?php 
//Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
//if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){

?>
        // Asociar el widget de validación al formulario
        $("#experienciaProfesional").validationEngine({
            promptPosition : "centerRight", 
            scroll: false
        });

        $(function() {
            $("#experienciaProfesional").submit(function() {
                $resultado=$("#experienciaProfesional").validationEngine("validate");
                
                if ($resultado) {
                
                    return true;
                }
                return false;
            });
        });
        
        $("#experienciaProfesional").change(function(){
            $("#detalleDocencia").val('');
            var camposForm = [ "entidad", "otraEntidad", "cargo", "fechaInicio", "fechaFin", "numeActa", "fechaActa", "numeCaso", "duracion", "puntaje" ];
            
            var texto = '';
            $("#experienciaProfesional").find(':input').each(function() {
                
                var elemento= this;               
                
                if($.inArray(elemento.id,camposForm) !== -1)
                {                
                    
                    if(elemento.value != '')
                    {
                        if(elemento.id == 'entidad')
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
        
       $("#entidad").change(function() {	
		
        if($("#entidad").val()!= -1 && $("#entidad").val()!=''){
			
			$("#divOtraEntidad").css('display','none');
			$("#otraEntidad").val('');
			$("#otraEntidad").attr('disabled','disabled');
				
									
		}else{					
					
				$("#divOtraEntidad").css('display','block');
				$("#otraEntidad").removeAttr('disabled');
				$("#entidad").attr("class", "selectboxdiv  select2-offscreen");				
			}		
		});
		
		 $("#entidad").ready(function() {	
		
        if($("#entidad").val()!= -1 && $("#entidad").val()!=''){
			
			$("#otraEntidad").attr('disabled','disabled');
				
									
		}else{					
					
			$("#otraEntidad").removeAttr('disabled');
			}		
		});

        $("#tipo_entidad").select2();
        $("#entidad").select2();
        //$("#identificacionFinalConsulta").select2();
        //$("#docente").select2();
        
        $('#fechaInicio').datepicker({
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
var lockDate = new Date($('#fechaInicio').datepicker('getDate'));
var ani=parseInt(lockDate.getFullYear());
var anios= parseInt($('#duracion').val());
 var anio_max=new Date(anios+ani,lockDate.getMonth(),lockDate.getDate());
//lockDate.setDate(lockDate.getDate() + 1);
$('#fechaFin').removeAttr('disabled');
$('#fechaFin').val('');
$('input#fechaFin').datepicker('option', 'minDate', lockDate);
$('input#fechaFin').datepicker('option', 'minDate', lockDate);

$('#puntaje').val('');

}
});
        
        $('#fechaFin').datepicker({
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
var lockDateFin = new Date($('#fechaFin').datepicker('getDate'));
var lockDateInicial = new Date($('#fechaInicio').datepicker('getDate'));

var anio_fin=lockDateFin.getFullYear();
var anio_inicial=lockDateInicial.getFullYear();
duracion = new Date(lockDateFin -lockDateInicial);
 var days = duracion/1000/60/60/24;
//$('#duracion').val( days);
$('#fechaActa').removeAttr('disabled');
$('#puntaje').val('');
$('#fechaActa').val('');
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
//lockDate.setDate(lockDate.getDate() + 1);
$('input#fechaInicio').datepicker('option', 'maxDate', lockDate);
$('input#fechaFin').datepicker('option', 'maxDate', lockDate);
}
});
                
        
                $("#puntaje").change(function(event) {

        
        var lockDateFin = new Date($('#fechaFin').datepicker('getDate'));
		var lockDateInicial = new Date($('#fechaInicio').datepicker('getDate'));

		var anio_fin=lockDateFin.getFullYear();
		var anio_inicial=lockDateInicial.getFullYear();

		duracion = new Date(lockDateFin -lockDateInicial);
 		var dias = duracion/1000/60/60/24;
        var puntaje = ((parseInt(dias)*3)/365);
        
        
        if(puntaje<0.1){
        
        puntaje = (0.1);
        
        }
        
        
        $("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all  validate[required, custom[number],min[0.1],max["+puntaje+"]]");
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
        
        
     


