<?php 
//Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
//if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){

?>
        // Asociar el widget de validación al formulario
        $("#produccionvideosDocente").validationEngine({
            promptPosition : "centerRight", 
            scroll: false,
            autoHidePrompt: true,
            autoHideDelay: 3000
        });
        
        $(function() {
            $("#produccionvideosDocente").submit(function() {
                $resultado=$("#produccionvideosDocente").validationEngine("validate");
                
                if ($resultado) {
                
                    return true;
                }
                return false;
            });
        });
        
        $("#produccionvideosDocente").change(function(){
            $("#detalleDocencia").val('');
            var camposForm = [ "titulo_video", "numAuto", "numAutoUD", "fechaVideo", "impacto", "caracter", "numeActa", "fechaActa", "numeCaso", "numEvaluadores", "puntaje"];
            
            var texto = '';
            $("#produccionvideosDocente").find(':input').each(function() {
                
                var elemento= this;               
                
                if($.inArray(elemento.id,camposForm) !== -1)
                {                
                    
                    if(elemento.value != '')
                    {
                        if(elemento.id == 'impacto' || elemento.id == 'caracter' || elemento.id == 'numEvaluadores')
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
        
        $("#impacto").select2();
        $("#caracter").select2();
                
        $("#contexto").select2();
        
        $("#numEvaluadores").select2();
        
        $("#uniEvaluador1").select2();
        $("#uniEvaluador2").select2();
        $("#uniEvaluador3").select2();
        
       
        $( "#impacto" ).change(function() {

            $("#puntaje").val(''); 
            $("#puntaje").attr("class", "cuadroTexto"); 
            switch($("#impacto").val())
            {
                //Nacional
                case '1':
                    switch($("#caracter").val())
                    {
                         case '1':
                            $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, condRequired[impacto], custom[number],min[0.1],max[12]]"); 
                         break;
                         case '2':
                            $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, condRequired[impacto], custom[number],min[0.1],max[5.6]]"); 
                         break;
                    }
                    
                break;
                //Internacional
                case '2':
                    switch($("#caracter").val())
                    {
                         case '1':
                            $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, condRequired[impacto], custom[number],min[0.1],max[7]]"); 
                         break;
                         case '2':
                            $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, condRequired[impacto], custom[number],min[0.1],max[9.6]]"); 
                         break;
                    }
                break;
                
            }
        
        });  
        
        $( "#caracter" ).change(function() {

            $("#puntaje").val(''); 
            $("#puntaje").attr("class", "cuadroTexto"); 
            switch($("#impacto").val())
            {
                //Nacional
                case '1':
                    switch($("#caracter").val())
                    {
                         case '1':
                            $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, condRequired[impacto], custom[number],min[0.1],max[12]]"); 
                         break;
                         case '2':
                            $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, condRequired[impacto], custom[number],min[0.1],max[5.6]]"); 
                         break;
                    }
                    
                break;
                //Internacional
                case '2':
                    switch($("#caracter").val())
                    {
                         case '1':
                            $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, condRequired[impacto], custom[number],min[0.1],max[7]]"); 
                         break;
                         case '2':
                            $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, condRequired[impacto], custom[number],min[0.1],max[9.6]]"); 
                         break;
                    }
                break;
                
            }
        
        });  
        
        // Validacion para el numero de evauadores
          
        $( "#numEvaluadores" ).change(function() {
            switch($("#numEvaluadores").val())
            {
                case '1':
                    $("#divEv2").css('display','none');
                    $("#divEv3").css('display','none');
                    
                    $("#nomEvaluador1").val(' ');
                                        
                    $("#puntEvaluador1").val(' ');
                                       
                    $("#nomEvaluador2").attr("class", "ui-widget ui-widget-content ui-corner-all");
                    $("#puntEvaluador2").attr("class", "ui-widget ui-widget-content ui-corner-all");
                    
                    $("#nomEvaluador3").attr("class", "ui-widget ui-widget-content ui-corner-all");
                    $("#puntEvaluador3").attr("class", "ui-widget ui-widget-content ui-corner-all");
                break;
            
                case '2':
                    
                    $("#divEv2").css('display','block');
                    $("#divEv3").css('display','none');
                                        
                    $("#nomEvaluador3").val(' ');
                    
                    $("#puntEvaluador3").val(' ');
                    
                    $("#nomEvaluador2").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, minSize[6],custom[onlyLetterSp]]");                    
                    $("#puntEvaluador2").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, min[0.1]]");
                    
                    $("#nomEvaluador3").attr("class", "ui-widget ui-widget-content ui-corner-all");
                    $("#puntEvaluador3").attr("class", "ui-widget ui-widget-content ui-corner-all");
                    
                break;
                case '3':
                
                    $("#divEv2").css('display','block');
                    $("#divEv3").css('display','block');
                    
                                        
                    $("#nomEvaluador2").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, minSize[6],custom[onlyLetterSp]]");                    
                    $("#puntEvaluador2").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, min[0.1]]");
                    
                    $("#nomEvaluador3").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, minSize[6],custom[onlyLetterSp]]");                    
                    $("#puntEvaluador3").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, min[0.1]]");
                    
                break;
            }
          });
        
        
        $('#fechaVideo').datepicker({
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
            var lockDate = new Date($('#fechaVideo').datepicker('getDate'));
            //lockDate.setDate(lockDate.getDate() + 1);
            $('input#fechaActa').datepicker('option', 'minDate', lockDate);
            }
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
	dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa']
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
	dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa']
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
	dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'], 
	onSelect: function(dateText, inst) {
            var lockDate = new Date($('#fechaActa').datepicker('getDate'));
            //lockDate.setDate(lockDate.getDate() + 1);
            $('input#fechaVideo').datepicker('option', 'maxDate', lockDate);
            }
        });
        
        $("#facultad").select2();
        $("#proyecto").select2();
        $("#categoria").select2();
        
        $('#tablaTitulos').dataTable( {
                "sPaginationType": "full_numbers"
        } );
        
                       
        $(function() {
		$(document).tooltip({});
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
          