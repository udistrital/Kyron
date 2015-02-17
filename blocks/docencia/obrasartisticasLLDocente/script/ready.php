<?php 
//Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
//if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){

?>
        // Asociar el widget de validación al formulario
        $("#obrasartisticasLLDocente").validationEngine({
            promptPosition : "centerRight", 
            scroll: false,
            autoHidePrompt: true,
            autoHideDelay: 10000
        });

        $(function() {
            $("#obrasartisticasLLDocente").submit(function() {
                $resultado=$("#obrasartisticasLLDocente").validationEngine("validate");
                
                if ($resultado) {
                
                    return true;
                }
                return false;
            });
        });

        
        $("#obrasartisticasLLDocente").change(function(){
            $("#detalleDocencia").val('');
            var camposForm = [ "tipo_obra_artistica", "titulo_obra", "medio_publi", "fechaObra", "numeActa", "fechaActa", "numeCaso","puntaje"];
            
            var texto = '';
            $("#obrasartisticasLLDocente").find(':input').each(function() {
                
                var elemento= this;               
                
                if($.inArray(elemento.id,camposForm) !== -1)
                {                
                    
                    if(elemento.value != '')
                    {
                        if(elemento.id == 'tipo_obra_artistica')
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
        
        $( "#tipo_obra_artistica" ).change(function() {
            switch($("#tipo_obra_artistica").val())
            {
                case '1':
                    $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[72]]");
                break;
                case '2':
                    $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[48]]");
                break;
                case '3':
                    $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[48]]");
                break;
            }
          });
        
        $("#tipo_entidad").select2();
        $("#entidad").select2();
         $("#contexto_entidad").select2();
        
        $('#fechaInicio').datepicker({
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
        
        
        
        
          $('#fechaObra').datepicker({
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
            var lockDate = new Date($('#fechaObra').datepicker('getDate'));
            //lockDate.setDate(lockDate.getDate() + 1);
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
	dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
        onSelect: function(dateText, inst) {
            var lockDate = new Date($('#fechaActa').datepicker('getDate'));
            //lockDate.setDate(lockDate.getDate() + 1);
            $('input#fechaObra').datepicker('option', 'maxDate', lockDate);
            }
        });
        
        //$("#docente").select2();
        //$("#docenteConsulta").select2();
        $("#tipo_obra_artistica").select2();
        $("#facultad").select2();
        $("#proyecto").select2();
        $("#categoria").select2();
        
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
        
        
     


