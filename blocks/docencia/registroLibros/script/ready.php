<?php 
//Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
//if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){

?>
        // Asociar el widget de validación al formulario
        $("#registroLibros").validationEngine({
            promptPosition : "centerRight", 
            scroll: false,
            autoHidePrompt: true,
            autoHideDelay: 2000
        });

        $(function() {
            $("#registroLibros").submit(function() {
                $resultado=$("#registroLibros").validationEngine("validate");
                
                if ($resultado) {
                
                    return true;
                }
                return false;
            });
        });
        
        
        $("#registroLibros").change(function(){
            $("#detalleDocencia").val('');
            var camposForm = [ "titulolibro", "tipo_libro", "entidadCertifica", "codigo_numeracion", "num_autores_libro", "num_autores_libro_universidad", "editorial", 
            "numeActa", "fechaActa", "numeCaso", "numEvaluadores", "puntaje"];
            
            var texto = '';
            $("#registroLibros").find(':input').each(function() {
                
                var elemento= this;               
                
                if($.inArray(elemento.id,camposForm) !== -1)
                {                
                    
                    if(elemento.value != '')
                    {
                        if(elemento.id == 'tipo_libro' || elemento.id == 'entidadCertifica' || elemento.id == 'editorial')
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
        
        $( "#tipo_libro" ).change(function() {
            switch($("#tipo_libro").val())
            {
                case '1':
                    $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[20]]");
                    $("#div_entidadCertifica").css("display","block");
                break;
                case '2':
                    $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[15]]");
                    $("#div_entidadCertifica").css("display","none");
                break;
                case '3':
                    $("#puntaje").attr("class", "ui-widget ui-widget-content ui-corner-all validate[required, custom[number],min[0.1],max[15]]");
                    $("#div_entidadCertifica").css("display","none");
                break;
            }
          });

        $("#entidadCertifica").select2();
        $("#editorial").select2();
        $("#tipo_libro").select2();
        $("#categoriaLibro").select2();
        $("#entidad").select2();
        
        $("#tipoTrabajo").select2();
        $("#categoriaTrabajo").select2();
        $("#numAuto").select2();
        //$("#docente").select2();
        //$("#docenteConsulta").select2();
        $("#identificacion").attr('disabled','disabled');
        
        
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
        
          
        $("#numEvaluadores").select2();
        $("#uniEvaluador1").select2();
        $("#uniEvaluador2").select2();
        $("#uniEvaluador3").select2();
           
        $('#anio_libro').datepicker( {   
                changeYear: true,
                maxDate:0,
                monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
                'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                         showButtonPanel: true,
                dateFormat: 'yy',
                onClose: function(dateText, inst) {
                        //lockDate.setDate(lockDate.getDate() + 1);
                        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                        $(this).datepicker('setDate', new Date(year, 1, 1));
                        var strDate ="01/01"+"/"+year;
                        var fechamin=new Date(year, 1, 1);
                        $('#fechaActa').removeAttr('disabled');
                        $('#fechaActa').val(' ');
                        $('input#fechaActa').datepicker('option', 'minDate', fechamin);

                 }      			
      	     		
        });

		
		
        $("#anio_libro").focus(function () {
                $(".ui-datepicker-calendar").hide();
                $("#ui-datepicker-div").position({
                            my: "center top",
                            at: "center bottom",
                            of: $(this)
                        });
		});
             
        // Validacion para el numero de Evaluadores
          
         $( "#numEvaluadores" ).change(function() {
            switch($("#numEvaluadores").val())
            {
                case '1':
                    $("#divEv2").css('display','none');
                    $("#divEv3").css('display','none');
                   
                break;
            
                case '2':
                    
                    $("#divEv2").css('display','block');
                    $("#divEv3").css('display','none');
                    
                    $("#idenEvaluador3").val('');                                        
                    $("#nomEvaluador3").val('');
                    $("#puntEvaluador3").val('');
                        
                break;
                case '3':
                
                    $("#divEv2").css('display','block');
                    $("#divEv3").css('display','block');
                         
                break;
            }
          });
        
        
        $( "#tipo_libro" ).change(function() {
            $("#puntaje").val('');
        });
        
        
        $('#tablaTitulos').dataTable( {
                "sPaginationType": "full_numbers",
                "jQueryUI": true
        } );  
        
     


