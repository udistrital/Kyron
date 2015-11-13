<?php
$indice = 0;
//$funcion [$indice ++] = "jquery.validationEngine.js";
//$funcion [$indice ++] = "jquery.validationEngine-es.js";
$funcion [$indice ++] = "select2.min.js";
$funcion [$indice ++] = "select2_locale_es.js";
$funcion [$indice ++] = "jquery.dataTables.min.js";
//$funcion [$indice ++] = "timepicker.js";
//$funcion [$indice ++] = "jquery.autocomplete.js";
//$funcion [$indice ++] = "jquery.autocomplete.min.js";
$embebido [$indice] = true;
$funcion [$indice ++] = "ajax.php";
$embebido [$indice] = true;
$funcion [$indice ++] = "scriptLocal/validarCampoNumerico.php";
$embebido [$indice] = true;
$funcion [$indice ++] = "scriptLocal/campoFecha.php";
$embebido [$indice] = true;
$funcion [$indice ++] = "scriptLocal/evaluadores.php";
$embebido [$indice] = true;
$funcion [$indice ++] = "scriptLocal/asignacionPuntaje.js";


$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" );

if ($esteBloque ["grupo"] == "") {
	$rutaBloque .= "/blocks/" . $esteBloque ["nombre"];
} else {
	$rutaBloque .= "/blocks/" . $esteBloque ["grupo"] . "/" . $esteBloque ["nombre"];
}

$_REQUEST['tiempo']=time();

if (isset ( $funcion [0] )) {
	foreach ( $funcion as $clave => $nombre ) {
		if (! isset ( $embebido [$clave] )) {
			echo "\n<script type='text/javascript' src='" . $rutaBloque . "/script/" . $nombre . "'>\n</script>\n";
		} else {
			echo "\n<script type='text/javascript'>";
			include ($nombre);
			echo "\n</script>\n";
		}
	}
}

?>
