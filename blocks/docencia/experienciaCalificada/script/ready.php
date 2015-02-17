<?php
// Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
// if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){
?>
// Asociar el widget de validación al formulario
$("#experienciaCalificada").validationEngine({
promptPosition : "centerRight", 
scroll: false,
autoHidePrompt: true,
autoHideDelay: 2000
});

$(function() {
$("#experienciaCalificada").submit(function() {
$resultado=$("#experienciaCalificada").validationEngine("validate");

if ($resultado) {

return true;
}
return false;
});
});


        $("#experienciaCalificada").change(function(){
            $("#detalleDocencia").val('');
            var camposForm = [ "experiencia", "numeResolucion", "emiResolucion", "fechaResolucion", "numeActa", "fechaActa", "puntaje"];
            
            var texto = '';
            $("#experienciaCalificada").find(':input').each(function() {
                
                var elemento= this;               
                
                if($.inArray(elemento.id,camposForm) !== -1)
                {                
                    
                    if(elemento.value != '')
                    {
                        if(elemento.id == 'experiencia' || elemento.id == 'emiResolucion')
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


});



$('#fechaResolucion').datepicker({
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
onSelect: function(dateValue, inst) {
                        $("#fechaActa").datepicker("option", "minDate", dateValue)
                    }

});


//asignando los puntajes
$("#experiencia").ready(function(event) 
{

var valor=$("#experiencia").val();

if (valor==1){
$("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[11]]");
}

if (valor==2){
$("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[9]]"); 
}

if (valor==3){
$("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[6]]");
}

if (valor==4){
$("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[9]]");
}

if (valor==5){
$("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[6]]");
}

if (valor==6){
$("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[6]]");
}

if (valor==7){
$("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[6]]");
}

if (valor==8){
$("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[6]]");
}

if (valor==9){
$("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[2]]");
}

if (valor==10){
$("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[2]]");
}

if (valor==11){
$("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[4]]");
}


});



$("#experiencia").change(function(event) 
{

var valor=$("#experiencia").val();

if (valor==1){
$("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[11]]");
}

if (valor==2){
$("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[9]]"); 
}

if (valor==3){
$("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[6]]");
}

if (valor==4){
$("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[9]]");
}

if (valor==5){
$("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[6]]");
}

if (valor==6){
$("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[6]]");
}

if (valor==7){
$("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[6]]");
}

if (valor==8){
$("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[6]]");
}

if (valor==9){
$("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[2]]");
}

if (valor==10){
$("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[2]]");
}

if (valor==11){
$("#puntaje").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[4]]");
}
});


$("#facultad").select2();
$("#proyecto").select2();
$("#experiencia").select2();
$("#emiResolucion").select2();
$("#numResolucion").select2();
//$("#docente").select2();
//$("#identificacionFinalConsulta").select2();
$("#identificacion").attr('disabled','disabled');


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


     $('#tablaTitulos').dataTable( {
                "sPaginationType": "full_numbers"
        } );
        
                       
        $(function() {
		$(document).tooltip();
	});
	

