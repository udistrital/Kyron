<?php
$indice = 0;

$estilo = array();
// $estilo [$indice++] = "default.css";
// $estilo [$indice++] = "style.css";
// $estilo [$indice++] = "animate.css";
$estilo[$indice++]="style.css";
$estilo[$indice++]="grande.css";
//$estilo = array();

$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" );

if ($unBloque ["grupo"] == "") {
	$rutaBloque .= "/blocks/" . $unBloque ["nombre"];
} else {
	$rutaBloque .= "/blocks/" . $unBloque ["grupo"] . "/" . $unBloque ["nombre"];
}

foreach ( $estilo as $nombre ) {
	echo "<link rel='stylesheet' type='text/css' href='" . $rutaBloque . "/css/" . $nombre . "'>\n";
}
echo "<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>\n";
echo "<link href='http://fonts.googleapis.com/css?family=Oswald:700' rel='stylesheet' type='text/css'>\n";

?>
