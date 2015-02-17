<?php 
//Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
//if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){

?>
        // Asociar el widget de validación al formulario
        $("#ponenciaDocente").validationEngine({
            promptPosition : "topRight", 
            scroll: false,
            autoHidePrompt: true,
            autoHideDelay: 2000
        });

        $(function() {
            $("#ponenciaDocente").submit(function() {
                $resultado=$("#ponenciaDocente").validationEngine("validate");
                
                if ($resultado) {
                
                    return true;
                }
                return false;
            });
        });

        
        $("#ponenciaDocente").change(function(){
            $("#detalleDocencia").val('');
            var camposForm = [ "titulo_ponencia", "autoresPonencia", "fechaPonencia", "contexto", "pais1", "ciudad1", "pais", "ciudad", "evento", "num_certificado", "autoresUD", "numeActa", "fechaActa", "numeCaso", "puntaje"];
            
            var texto = '';
            $("#ponenciaDocente").find(':input').each(function() {
                
                var elemento= this;               
                
                if($.inArray(elemento.id,camposForm) !== -1)
                {                
                    
                    if(elemento.value != '')
                    {
                        if(elemento.id == 'contexto' || elemento.id == 'pais1' || elemento.id == 'ciudad1' || elemento.id == 'pais' || elemento.id == 'ciudad')
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
        //$("#docenteConsulta").select2();
        
        $("#pais").select2();
        $("#ciudad").select2();
        $("#ciudad1").select2();
        //$("#identificacionFinalConsulta").select2();
        
         $("#contexto").select2();
        
            $("#contexto").change(function(event) 
                {
 		    if ($("#contexto").val()== 2)
                    {
                        $("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[48]]");
                        $("#seleccionpais").css('display','none');
                        $('#pais1> option[value="COL"]').attr('selected', 'selected');                        
                        $('#pais1').attr('disabled','True');
         				$("#seleccionpais1").css('display','block');
                    }else if ($("#contexto").val()== 1)
                        {
                            $("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all  validate[required, custom[number],min[0.1],max[24]]");
                            $("#seleccionpais").css('display','none');
                            $('#pais1> option[value="COL"]').attr('selected', 'selected');
                            $('#pais1').attr('disabled','True');
                            $("#seleccionpais1").css('display','block');
                        }else if ($("#contexto").val()== 3)
                        {
                            $("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all  validate[required, custom[number],min[0.1],max[84]]");
                            $("#seleccionpais1").css('display','none');
                            $("#seleccionpais").css('display','block');
       
                        }else{
                            $("#puntaje").val(''); 
                            $("#seleccionpais1").css('display','none');
                            $("#seleccionpais").css('display','none');
                        }
            });
        
        $('#fechaPonencia').datepicker({
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
var lockDate = new Date($('#fechaPonencia').datepicker('getDate'));
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
$('input#fechaPonencia').datepicker('option', 'maxDate', lockDate);
}
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
        
        
     


