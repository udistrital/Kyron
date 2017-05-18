
var campoFecha = [];
var campoFechaInput = [];

var indiceA = 0;
var indiceB= 0;
var cont = 0;

campoFecha[indiceA++] = "#<?php echo $this->campoSeguro('fechaActaLibro')?>";
campoFechaInput[indiceB++] = "input#<?php echo $this->campoSeguro('fechaActaLibro')?>";


$(campoFecha).each(function(){
	$(this.valueOf()).datepicker({
		dateFormat: 'yy-mm-dd',
		maxDate: -1,
		yearRange: '-50:+0',
		changeYear: true,
		changeMonth: true,
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
		'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
		dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
		dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
		dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		onSelect: function(dateText, inst) {
		    window.checkearFechaVieja();
			var lockDate = new Date($(this.valueOf()).datepicker('getDate'));
			$(campoFechaInput[cont]).datepicker('option', 'minDate', lockDate);
		}, onClose: function() {
			if ($(campoFechaInput[cont]).val()!=''){
                $(this.valueOf()).attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required]");
            }else {
            	$(this.valueOf()).attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all ");
            }
		}
	})
	cont++;
});

