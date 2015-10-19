$( document ).ready(function() {

	/*PUNTAJES ASIGNADOS SEGÚN EL TIPO DE EXPERIENCIA CALIFICADA
	Tipo de experiencia (lista desplegable)
	Docente                                     Puntos: 4
	Rector                                       Puntos: 11
	Vicerrector                                 Puntos: 9
	Decano                                      Puntos: 6
	Secretaria general                       Puntos: 9
	Jefe de oficina                             Puntos: 6
	Director de oficina de investigación    Puntos: 6
	Coordinador Proyecto curricular          Puntos: 6
	Jefe de Oficina de Extensión                 Puntos: 6
	Director instituto escuela o departamento  Puntos: 2
	Director unidad de gestión académico administrativa Puntos: 2*/

	asignarPuntaje();
	
	$("#<?php echo $this->campoSeguro('tipoExperiencia')?>").change(function(event){
		asignarPuntaje();
	});
		
	function asignarPuntaje(){
		
		var valor=$("#<?php echo $this->campoSeguro('tipoExperiencia')?>").val();
		if (valor==1){
			$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[11]]");
		}
		if (valor==2){
			$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[9]]"); 
		}
		if (valor==3){
			$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[6]]");
		}
		if (valor==4){
			$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[9]]");
		}
		if (valor==5){
			$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[6]]");
		}
		if (valor==6){
			$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[6]]");
		}
		if (valor==7){
			$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[6]]");
		}
		if (valor==8){
			$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[6]]");
		}
		if (valor==9){
			$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[2]]");
		}
		if (valor==10){
			$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[2]]");
		}
		if (valor==11){
			$("#<?php echo $this->campoSeguro('puntaje')?>").attr("class", "cuadroTexto ui-widget ui-widget-content ui-corner-all   validate[required, custom[number],min[0.1],max[4]]");
		}
	}

});
