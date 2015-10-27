$("#experienciaInvestigacion").validationEngine({
promptPosition : "bottomRight:-150", 
scroll: false,
autoHidePrompt: true,
autoHideDelay: 2000
});

$(function() {
	$("#experienciaInvestigacion").submit(function() {
		$resultado=$("#experienciaInvestigacion").validationEngine("validate");
		if ($resultado) {
			return true;
		}
		return false;
	});
});

$("#experienciaInvestigacionRegistrar").validationEngine({
	promptPosition : "bottomRight:-150", 
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});

$(function() {
$("#experienciaInvestigacionRegistrar").submit(function() {
$resultado=$("#experienciaInvestigacionRegistrar").validationEngine("validate");

if ($resultado) {

return true;
}
return false;
});
});

$(function () {
    $("button").button().click(function (event) { 
        event.preventDefault();
    });
});

$(function() {
	$("#experienciaInvestigacionModificar").submit(function() {
		$resultado=$("#experienciaInvestigacionModificar").validationEngine("validate");
		if ($resultado) {
			return true;
		}
		return false;
	});
});

$("#experienciaInvestigacionModificar").validationEngine({
	promptPosition : "bottomRight:-150", 
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});

$('#tablaTitulos').dataTable( {
	"sPaginationType": "full_numbers"
});
        
////////////Función que organiza los tabs en la interfaz gráfica//////////////
$(function() {
	$("#tabs").tabs();
}); 
//////////////////////////////////////////////////////////////////////////////

// Asociar el widget de validación al formulario

/////////Se define el ancho de los campos de listas desplegables///////
$('#<?php echo $this->campoSeguro('docente')?>').width(465);      
$('#<?php echo $this->campoSeguro('facultad')?>').width(450);      
$('#<?php echo $this->campoSeguro('proyectoCurricular')?>').width(450);      

$('#<?php echo $this->campoSeguro('docenteRegistrar')?>').width(465);
$('#<?php echo $this->campoSeguro('tipoExperiencia')?>').width(450);
$('#<?php echo $this->campoSeguro('entidad')?>').width(450);

//////////////////**********Se definen los campos que requieren campos de select2**********////////////////

$("#<?php echo $this->campoSeguro('facultad')?>").select2();
$("#<?php echo $this->campoSeguro('proyectoCurricular')?>").select2();

$("#<?php echo $this->campoSeguro('tipoExperiencia')?>").select2();
$("#<?php echo $this->campoSeguro('entidad')?>").select2();

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$("#<?php echo $this->campoSeguro('entidad')?>").change(function() {
	if($("#<?php echo $this->campoSeguro('entidad')?>").val()==''){
		$("#<?php echo $this->campoSeguro('otraEntidad')?>").removeAttr("disabled");
		var idDatosEstudiantes = [
                       	 '<?php echo $this->campoSeguro('otraEntidad')?>',
                       ];
		//Agrega required a todos los campos de los estudiantes
		$.each(idDatosEstudiantes,function (i,v){
			var obj = $("#"+v);
			if(obj.length>0){
				var clases = obj.attr('class').split(' ');
				var claseValidate = $.grep(clases,function(v,i){return v.indexOf('validate')>-1})[0];
				obj.removeClass(claseValidate);
				claseValidate = claseValidate.insertAt(claseValidate.indexOf("[")+1,'required,');
				obj.addClass(claseValidate);
			}
		});
	}else{
		$("#<?php echo $this->campoSeguro('otraEntidad')?>").attr("disabled", "disabled");
		$("#<?php echo $this->campoSeguro('otraEntidad')?>").val("");
		var idDatosEstudiantes = [
                       	 '<?php echo $this->campoSeguro('entidad')?>',
                       ];
		//Agrega required a todos los campos de los estudiantes
		$.each(idDatosEstudiantes,function (i,v){
			var obj = $("#"+v);
			if(obj.length>0){
				var clases = obj.attr('class').split(' ');
				var claseValidate = $.grep(clases,function(v,i){return v.indexOf('validate')>-1})[0];
				obj.removeClass(claseValidate);
				claseValidate = claseValidate.insertAt(claseValidate.indexOf("[")+1,'required,');
				obj.addClass(claseValidate);
			}
		});
	}
});

if($("#<?php echo $this->campoSeguro('entidad')?>").val()!=''){
		$("#<?php echo $this->campoSeguro('otraEntidad')?>").attr("disabled", "disabled");
}else{

		String.prototype.insertAt=function(index, string) { 
	  		return this.substr(0, index) + string + this.substr(index);
		}
		var idDatosEstudiantes = [
                       	 '<?php echo $this->campoSeguro('otraEntidad')?>',
                       ];
		//Agrega required a todos los campos de los estudiantes
		$.each(idDatosEstudiantes,function (i,v){
			var obj = $("#"+v);
			if(obj.length>0){
				var clases = obj.attr('class').split(' ');
				var claseValidate = $.grep(clases,function(v,i){return v.indexOf('validate')>-1})[0];
				obj.removeClass(claseValidate);
				claseValidate = claseValidate.insertAt(claseValidate.indexOf("[")+1,'required,');
				obj.addClass(claseValidate);
			}
		});
}

String.prototype.insertAt=function(index, string) { 
	  return this.substr(0, index) + string + this.substr(index);
	}

