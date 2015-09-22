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
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

