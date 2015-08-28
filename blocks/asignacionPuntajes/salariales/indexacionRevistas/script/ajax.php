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
<script type='text/javascript'>

alert($("#<?php echo $this->campoSeguro('docente')?>").val());        
$( "#<?php echo $this->campoSeguro('docente')?>" ).keyup(function() {
	$('#<?php echo $this->campoSeguro('docente') ?>').val($('#<?php echo $this->campoSeguro('docente') ?>').val().toUpperCase());
});

$( "#<?php echo $this->campoSeguro('docente')?>" ).change(function() {
	if($('#<?php echo $this->campoSeguro('docente') ?>').val()==''){
		$("#<?php echo $this->campoSeguro('id_proveedor') ?>").val('');
	}
});

$("#<?php echo $this->campoSeguro('docente') ?>").autocomplete({
	minChars: 3,
	serviceUrl: '<?php echo $urlFinalDocente; ?>',
	onSelect: function (suggestion) {
    	$("#<?php echo $this->campoSeguro('id_proveedor') ?>").val(suggestion.data);
	}
});

</script>

