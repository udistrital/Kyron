<?php 
//Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
//if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){

?>
        // Asociar el widget de validación al formulario
        $("#titulosAcademicos").validationEngine({
            promptPosition : "centerRight", 
            scroll: false,
            autoHidePrompt: true,
            autoHideDelay: 2000
        });

        $(function() {
            $("#titulosAcademicos").submit(function() {

                $resultado=$("#titulosAcademicos").validationEngine("validate");
                
                if ($resultado) {
                
                    return true;
                }
                return false;
            });
        });

        $("#titulosAcademicos").change(function(){
            $("#detalleDocencia").val('');
            var camposForm = [ "tipo_titulo", "titulo_otorgado", "universidad", "fechaFin", "modalidad", "pais", "resolucion", "fechaResolucion", "entidadConvalida", "numeActa", "fechaActa", "numeCaso", "puntaje" ];
            
            var texto = '';
            $("#titulosAcademicos").find(':input').each(function() {
                
                var elemento= this;               
                
                if($.inArray(elemento.id,camposForm) !== -1)
                {                
                    
                    if(elemento.value != '')
                    {
                        if(elemento.id == 'tipo_titulo' || elemento.id == 'universidad' || elemento.id == 'modalidad' || elemento.id == 'pais')
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
        
        //$("#docenteConsultar").select2();
        $("#modalidad").select2();
        $("#tipo_titulo").select2();
        $("#universidad").select2();
        $("#pais").select2();
        
        $('#fechaInicio').datepicker({
        dateFormat: 'yy-mm-dd',
        maxDate: 0,
        changeYear: true,
        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
	'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
	monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
	dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
	dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
	dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
            onSelect: function(dateText, inst) 
            {
                var lockDate = new Date($('#fechaInicio').datepicker('getDate'));
                $('input#fechaFin').datepicker('option', 'minDate', lockDate);
            }
        });
        
        $('#fechaFin').datepicker({
        dateFormat: 'yy-mm-dd',
        maxDate: 0,
        changeYear: true,
        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
	'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
	monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
	dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
	dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
	dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
            onSelect: function(dateText, inst) 
            {
                var lockDate = new Date($('#fechaFin').datepicker('getDate'));
                $('input#fechaInicio').datepicker('option', 'maxDate', lockDate);
            }
        });
        
        $('#fechaResolucion').datepicker({
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
        $("#categoria").select2();
        //$("#identificacionFinalConsulta").select2();
        
        $('#tablaTitulos').dataTable( {
                "sPaginationType": "full_numbers"
        } );
        
	
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
        
         $( "#pais" ).change(function() {
            switch($("#pais").val())
            {
                case 'COL':
                    $("#resolucion").attr("class", "ui-widget ui-widget-content ui-corner-all");
                    $("#fechaResolucion").attr("class", "ui-widget ui-widget-content ui-corner-all");
                    $("#entidadConvalida").attr("class", "ui-widget ui-widget-content ui-corner-all");
                    
                    $("#resolucion").attr('disabled','disabled');
                    $("#fechaResolucion").attr('disabled','disabled');
                    $("#entidadConvalida").attr('disabled','disabled');
                    
                break;
                default:                    
                    $("#resolucion").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, minSize[1]]");
                    $("#fechaResolucion").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required]");
                    $("#entidadConvalida").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, minSize[5]]");
                    
                    $("#resolucion").removeAttr('disabled');
                    $("#fechaResolucion").removeAttr('disabled');
                    $("#entidadConvalida").removeAttr('disabled');
                break;
            }
          });
     
                   
          validarTitulosModificar();

