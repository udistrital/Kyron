<?php 
//Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
//if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){

?>
        // Asociar el widget de validación al formulario
        $("#premiosDocente").validationEngine({
            promptPosition : "centerRight", 
            scroll: false
        });

        $(function() {
            $("#premiosDocente").submit(function() {
                $resultado=$("#premiosDocente").validationEngine("validate");
                
                if ($resultado) {
                
                    return true;
                }
                return false;
            });
        });
        
        
        $("#premiosDocente").change(function(){
            $("#detalleDocencia").val('');
            var camposForm = [ "entidad", "otraEntidad", "tipo_entidad", "contexto_entidad", "concepto", "pais1", "ciudad1", "pais", "ciudad", 
            "fechaPremio", "numePersonas", "yearPrize", "numeActa", "fechaActa", "numeCaso", "puntaje"];
            
            var texto = '';
            $("#premiosDocente").find(':input').each(function() {
                
                var elemento= this;               
                
                if($.inArray(elemento.id,camposForm) !== -1)
                {                
                    
                    if(elemento.value != '')
                    {
                        if(elemento.id == 'entidad' || elemento.id == 'tipo_entidad' || elemento.id == 'contexto_entidad' || elemento.id == 'pais1' || elemento.id == 'ciudad1' 
                        || elemento.id == 'pais' || elemento.id == 'ciudad')
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

                $("#entidad").ready(function() {		
		
					if($("#entidad").val()!='-1' ){
						
						$("#otraEntidad").attr('disabled','True');						
					} 
		});       
        
        
        $("#entidad").change(function() {		
		
					if($("#entidad").val()!= -1 ){
						$("#otraEntidad").val('');
						$("#otraEntidad").attr('disabled','True');						
					}else if($("#entidad").val()== -1 ){					
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
       
                        }else{
                            $("#puntaje").val(''); 
                            $("#seleccionpais1").css('display','none');
                            $("#seleccionpais").css('display','none');
                        }
            });
            
            
            
                  $("#ciudad1").ready(function(event) 
                {
                 
                $("#pais").append(new Option("Seleccione...", "-1"))
                $("#ciudad").append(new Option("Seleccione...", "-1"))


 		         });
                $("#ciudad1").change(function(event) 
                {
                 
                $('#pais  option[value="-1"]').attr('selected', true);

 		         });
        
        
        $("#tipo_entidad").select2();
        $("#entidad").select2();
         $("#contexto_entidad").select2();
         //$("#docente").select2();
         $("#pais").select2();
        $("#ciudad").select2();
        $("#ciudad1").select2();
        $('#pais1').attr('disabled','True');
        
        
<!--         $( "#puntaje" ).spinner({ -->
<!--             min: 1, -->
<!--             max: 183, -->
<!--             step: 1, -->
<!--             start: 1, -->
<!--           }); -->
        
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
        
        
        
                
        $('#fechaPremio').datepicker({
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
var lockDate = new Date($('#fechaPremio').datepicker('getDate'));
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
$('input#fechaPremio').datepicker('option', 'maxDate', lockDate);
}
});
        

                $('#yearPrize').datepicker( {   
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
		
			$("#yearPrize").focus(function () {
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
        
        
     


