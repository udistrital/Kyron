$("#experienciaProfesional").validationEngine({
promptPosition : "bottomRight:-150", 
scroll: false,
autoHidePrompt: true,
autoHideDelay: 2000
});

$(function() {
	$("#experienciaProfesional").submit(function() {
		$resultado=$("#experienciaProfesional").validationEngine("validate");
		if ($resultado) {
			return true;
		}
		return false;
	});
});

$("#experienciaProfesionalRegistrar").validationEngine({
	promptPosition : "bottomRight:-150", 
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});

$(function() {
$("#experienciaProfesionalRegistrar").submit(function() {
$resultado=$("#experienciaProfesionalRegistrar").validationEngine("validate");

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
	$("#experienciaProfesionalModificar").submit(function() {
		$resultado=$("#experienciaProfesionalModificar").validationEngine("validate");
		if ($resultado) {
			return true;
		}
		return false;
	});
});

$("#experienciaProfesionalModificar").validationEngine({
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
$('#<?php echo $this->campoSeguro('tipoEntidad')?>').width(450);
$('#<?php echo $this->campoSeguro('entidad')?>').width(450);

//////////////////**********Se definen los campos que requieren campos de select2**********////////////////

$("#<?php echo $this->campoSeguro('facultad')?>").select2();
$("#<?php echo $this->campoSeguro('proyectoCurricular')?>").select2();

$("#<?php echo $this->campoSeguro('tipoEntidad')?>").select2();
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


/*Se limpia el campo de doncente a consultar o a registrar cuando no se realiza
una elección del listado desplegado*/

$("#<?php echo $this->campoSeguro('docente')?>").blur(function() {
 	$("#<?php echo $this->campoSeguro('docente')?>").val("");
});

$("#<?php echo $this->campoSeguro('docenteRegistrar')?>").blur(function() {
 	$("#<?php echo $this->campoSeguro('docenteRegistrar')?>").val("");
});
