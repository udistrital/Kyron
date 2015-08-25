<?php 
//Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
//if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){

?>
        // Asociar el widget de validación al formulario
        $("#indexacionRevistas").validationEngine({
            promptPosition : "centerRight", 
            scroll: false,
            autoHidePrompt: true,
            autoHideDelay: 2000
        });

        $(function() {
            $("#indexacionRevistas").submit(function() {
                $resultado=$("#indexacionRevistas").validationEngine("validate");
                
                if ($resultado) {
                
                    return true;
                }
                return false;
            });
        });
        
        $("#indexacionRevistas").change(function(){
            $("#detalleDocencia").val('');
            var camposForm = [ "nombre_revista", "contexto_entidad", "pais1", "indexacion", "pais", "indexacionInternacional", "ISSN", "año", "volumen", "No", "paginas", "titulo_articulo", "no_autores", "autoresUD", "fecha_publicacion", "numeActa", "fechaActa", "numeCaso", "puntaje" ];
            
            var texto = '';
            $("#indexacionRevistas").find(':input').each(function() {
                
                var elemento= this;               
                
                if($.inArray(elemento.id,camposForm) !== -1)
                {                
                    
                    if(elemento.value != '')
                    {
                        if(elemento.id == 'pais1' || elemento.id == 'indexacion' || elemento.id == 'pais' || elemento.id == 'indexacionInternacional')
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
        
        $("#contexto_entidad").change(function(event) 
                {
 		    if ($("#contexto_entidad").val()== 1)
                    {
                    
                        $("#seleccionpais").css('display','none');
                        $('#pais1> option[value="COL"]').attr('selected', 'selected');                        
                        $('#pais1').attr('disabled','True');
                        $("#seleccionpais1").css('display','block');
                        
                    }else if ($("#contexto_entidad").val()== 2)
                        {
                            
                            $("#seleccionpais1").css('display','none');
                            $("#seleccionpais").css('display','block');
                            $("#pais").select2();                           
                            
                        }else{
                            $("#puntaje").val(''); 
                            $("#seleccionpais1").css('display','none');
                            $("#seleccionpais").css('display','none');
                        }
            });
		$("#pais").select2();
        //$("#docente").select2();
        $("#contexto_entidad").select2();
        //$("#identificacionFinalConsulta").select2();
        //$("#institucion").select2();
        $("#indexacion").select2();
        $("#indexacionInternacional").select2();
        
        
          $("#indexacion").change(function(event) 
            {
 
            $('#puntaje').val('');
             
        });
        
                
          $("#indexacionInternacional").change(function(event) 
            {

            $('#puntaje').val('');
             
        });
        
        
            $("#contexto_entidad").change(function(event) 
            {

            $('#puntaje').val('');
             
        });
        
        
        $("#facultad").select2();
        $("#proyecto").select2();
        $("#categoria").select2();        
                  
           $("#puntaje").change(function(event) 
            {    
                if($("#contexto_entidad").val() == 1)
                {
                
                    switch($("#indexacion").val())
                    {                

                       case '7':
                            $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[15]]");
                        break;
                        case '8':
                            $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[12]]");
                        break;
                        case '9':
                            $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[8]]");
                        break;
                        case '10':
                            $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[3]]");
                        break;

                    }
                
                }else
                {
                    switch($("#indexacionInternacional").val())
                    {                

                        case '3':
                            $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[15]]");
                        break;
                        case '4':
                            $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[12]]");
                        break;
                        case '5':
                            $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[8]]");
                        break;
                        case '6':
                            $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[3]]");
                        break;

                    }
                
                }
            });  
        
            if($("#contexto_entidad").val() == 1)
                {
                
                    switch($("#indexacion").val())
                    {                

                       case '7':
                            $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[15]]");
                        break;
                        case '8':
                            $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[12]]");
                        break;
                        case '9':
                            $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[8]]");
                        break;
                        case '10':
                            $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[3]]");
                        break;

                    }
                
                }else
                {
                    switch($("#indexacionInternacional").val())
                    {                

                        case '3':
                            $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[15]]");
                        break;
                        case '4':
                            $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[12]]");
                        break;
                        case '5':
                            $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[8]]");
                        break;
                        case '6':
                            $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[3]]");
                        break;

                    }
                
                }
            
        $('#año').datepicker( {   
    	changeYear: true,
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
		
		$("#año").focus(function () {
    	$(".ui-datepicker-calendar").hide();
    	$("#ui-datepicker-div").position({
        my: "center top",
        at: "center bottom",
        of: $(this)
    		});
		});
		
		 $('#fecha_publicacion').datepicker({
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
var lockDate = new Date($('#fecha_publicacion').datepicker('getDate'));
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
$('input#fecha_publicacion').datepicker('option', 'maxDate', lockDate);
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
        
        
     


