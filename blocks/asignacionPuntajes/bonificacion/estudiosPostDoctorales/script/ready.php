$("#estudiosPostDoctorales").validationEngine({
promptPosition : "bottomRight:-150", 
scroll: false,
autoHidePrompt: true,
autoHideDelay: 2000
});

$(function() {
	$("#estudiosPostDoctorales").submit(function() {
		$resultado=$("#estudiosPostDoctorales").validationEngine("validate");
		if ($resultado) {
			return true;
		}
		return false;
	});
});

$("#estudiosPostDoctoralesRegistrar").validationEngine({
	promptPosition : "bottomRight:-150", 
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});

$(function() {
$("#estudiosPostDoctoralesRegistrar").submit(function() {
$resultado=$("#estudiosPostDoctoralesRegistrar").validationEngine("validate");

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
	$("#estudiosPostDoctoralesModificar").submit(function() {
		$resultado=$("#estudiosPostDoctoralesModificar").validationEngine("validate");
		if ($resultado) {
			return true;
		}
		return false;
	});
});

$("#estudiosPostDoctoralesModificar").validationEngine({
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
	if($("#<?php echo $this->campoSeguro('entidad')?>").val()==''){//Si no existe entidad
		$("#<?php echo $this->campoSeguro('otraEntidad')?>").removeAttr("disabled");//Se remueve el disable de otraEntidad
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
		var idDatosEstudiantes = [
             '<?php echo $this->campoSeguro('entidad')?>',
        ];
		//Remueve required a todos los campos de los estudiantes
		$.each(idDatosEstudiantes,function (i,v){
			var obj = $("#"+v);
			if(obj.length>0){
				var clases = obj.attr('class').split(' ');
				var claseValidate = $.grep(clases,function(v,i){return v.indexOf('validate')>-1})[0];
				obj.removeClass(claseValidate);
				claseValidate = claseValidate.replace("required,","");
				claseValidate = claseValidate.replace("required","");
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
		var idDatosEstudiantes = [
             '<?php echo $this->campoSeguro('otraEntidad')?>',
        ];
		//Remueve required a todos los campos de los estudiantes
		$.each(idDatosEstudiantes,function (i,v){
			var obj = $("#"+v);
			if(obj.length>0){
				var clases = obj.attr('class').split(' ');
				var claseValidate = $.grep(clases,function(v,i){return v.indexOf('validate')>-1})[0];
				obj.removeClass(claseValidate);
				claseValidate = claseValidate.replace("required,","");
				claseValidate = claseValidate.replace("required","");
				obj.addClass(claseValidate);
			}
		});
	}
});

String.prototype.insertAt=function(index, string) { 
	return this.substr(0, index) + string + this.substr(index);
}

if($("#<?php echo $this->campoSeguro('entidad')?>").val()!=''){
		$("#<?php echo $this->campoSeguro('otraEntidad')?>").attr("disabled", "disabled");
}else{

		
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

/*Se limpia el campo de doncente a consultar o a registrar cuando no se realiza
una elección del listado desplegado*/

$("#<?php echo $this->campoSeguro('docente')?>").blur(function() {
 	$("#<?php echo $this->campoSeguro('docente')?>").val("");
});

$("#<?php echo $this->campoSeguro('docenteRegistrar')?>").blur(function() {
 	$("#<?php echo $this->campoSeguro('docenteRegistrar')?>").val("");
});

