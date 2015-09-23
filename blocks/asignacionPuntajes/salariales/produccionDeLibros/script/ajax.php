<?php
/**
 *
 * Los datos del bloque se encuentran en el arreglo $esteBloque.
 */

// URL base
$url = $this->miConfigurador->getVariableConfiguracion ( "host" );
$url .= $this->miConfigurador->getVariableConfiguracion ( "site" );
$url .= "/index.php?";
// Variables
$cadenaACodificarDocente = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
$cadenaACodificarDocente .= "&procesarAjax=true";
$cadenaACodificarDocente .= "&action=index.php";
$cadenaACodificarDocente .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarDocente .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarDocente .= "&funcion=consultarDocente";
$cadenaACodificarDocente .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificarDocente, $enlace );

// URL definitiva
$urlFinalDocente = $url . $cadena;
?>

//Document Ready es necesario para que cargue correctamente.
$(document).ready(function(){

$( "#<?php echo $this->campoSeguro('docente')?>" ).keyup(function() {
	$('#<?php echo $this->campoSeguro('docente') ?>').val($('#<?php echo $this->campoSeguro('docente') ?>').val().toUpperCase());
});

$( "#<?php echo $this->campoSeguro('docente')?>" ).change(function() {
	if($('#<?php echo $this->campoSeguro('docente') ?>').val()==''){
		$("#<?php echo $this->campoSeguro('id_docente') ?>").val('');
	}
});

$("#<?php echo $this->campoSeguro('docente') ?>").autocomplete({
	minChars: 3,
	serviceUrl: '<?php echo $urlFinalDocente; ?>',
	onSelect: function (suggestion) {
    	$("#<?php echo $this->campoSeguro('id_docente') ?>").val(suggestion.data);
	}
});


//////////////////Función que se ejecuta al seleccionar alguna opcón del contexto de la revista////////////////////

$("#<?php echo $this->campoSeguro('tipoLibro')?>").change(function() {
	if($("#<?php echo $this->campoSeguro('tipoLibro')?>").val() == 1){

		$("#<?php echo $this->campoSeguro('entidadCertificadora')?>").html("");
		$("<option value=''>Seleccione .....</option>").appendTo("#<?php echo $this->campoSeguro('entidadCertificadora')?>");
		
		consultarEntidadCertificadora();
		
		$("#<?php echo $this->campoSeguro('entidad_div')?>").css('display','block'); 
		$('#<?php echo $this->campoSeguro('entidadCertificadora')?>').width(450);

		$("#<?php echo $this->campoSeguro('entidadCertificadora')?>").select2();
		
	}else{ //Se pone 1 porque en la base de datos el identificador de investigación es igual a 1.
		
		$("<option value=''>Seleccione .....</option>").appendTo("#<?php echo $this->campoSeguro('entidadCertificadora')?>");
		$("#<?php echo $this->campoSeguro('entidad_div')?>").css('display','none'); 
	}
	
});

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//////////////*******Función que permite enviar los caracteres a medida que se van ingresando e ir recibiendo una respuesta para ir mostrando posibles docentes*******/////////////// 
//////////////////////ver en procecarajax.php la función consultarDocente y en sql.class.php ver la sentencia docente.////////////////////////////////////////////////////////////////
//////////////////////Para que esta función se ejecute correctamente debe agregar//
<?php
// Variables
$cadenaACodificarDocenteReg = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
$cadenaACodificarDocenteReg .= "&procesarAjax=true";
$cadenaACodificarDocenteReg .= "&action=index.php";
$cadenaACodificarDocenteReg .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificarDocenteReg .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificarDocenteReg .= "&funcion=consultarDocenteReg";
$cadenaACodificarDocenteReg .= "&tiempo=" . $_REQUEST ['tiempo'];
// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificarDocenteReg, $enlace );

// URL definitiva
$urlFinalDocenteReg = $url . $cadena;
?>

$(function () {
    $( "#<?php echo $this->campoSeguro('docenteRegistrar')?>" ).keyup(function() {
		$('#<?php echo $this->campoSeguro('docenteRegistrar') ?>').val($('#<?php echo $this->campoSeguro('docenteRegistrar') ?>').val().toUpperCase());
    });
    $("#<?php echo $this->campoSeguro('docenteRegistrar') ?>").autocomplete({
    	minChars: 3,
    	serviceUrl: '<?php echo $urlFinalDocente; ?>',
    	onSelect: function (suggestion) {        		
    	        $("#<?php echo $this->campoSeguro('id_docenteRegistrar') ?>").val(suggestion.data);
    	    }
    });

});

///////////////Función que se encarga de hacer dinámico el campo categoría////////////////  

<?php

$url = $this->miConfigurador->getVariableConfiguracion ( "host" );
$url .= $this->miConfigurador->getVariableConfiguracion ( "site" );
$url .= "/index.php?";

// Variables
$cadenaEntidadCertificadora = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
$cadenaEntidadCertificadora .= "&procesarAjax=true";
$cadenaEntidadCertificadora .= "&action=index.php";
$cadenaEntidadCertificadora .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaEntidadCertificadora .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaEntidadCertificadora .= "&funcion=consultarEntidadCertificadora";
$cadenaEntidadCertificadora .= "&tiempo=" . $_REQUEST ['tiempo'];
// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaEntidadCertificadora, $enlace );
// URL definitiva
$urlFinalCategoria = $url . $cadena;
?>

function consultarEntidadCertificadora(elem, request, response){
	$.ajax({
		url: "<?php echo $urlFinalCategoria?>",
		dataType: "json",
		data: { valor: ''},
		success: function(data){
			if(data[0]!=" "){
				$("#<?php echo $this->campoSeguro('entidadCertificadora')?>").html("");
				$("<option value=''>Seleccione .....</option>").appendTo("#<?php echo $this->campoSeguro('entidadCertificadora')?>");
				$.each(data , function(indice,valor){
					$("<option value='"+data[ indice ].id_universidad+"'>"+data[ indice ].nombre_universidad+"</option>").appendTo("#<?php echo $this->campoSeguro('entidadCertificadora')?>");
				});
			}
		}
	});
};

});

if($("#<?php echo $this->campoSeguro('tipoLibro')?>").val() == 1){
	$('#<?php echo $this->campoSeguro('entidadCertificadora')?>').width(470);
	var elem = $("#<?php echo $this->campoSeguro('entidadCertificadora')?>").select2();
}
