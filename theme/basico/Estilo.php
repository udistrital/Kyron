<?php
$indice=0;
$estilo[$indice++]="general.css";
$estilo[$indice++]="estiloCuadrosMensaje.css";
$estilo[$indice++]="estiloTexto.css";
$estilo[$indice++]="estiloFormulario.css";

$host=$this->miConfigurador->getVariableConfiguracion("host");
$sitio=$this->miConfigurador->getVariableConfiguracion("site");

if(isset($_REQUEST["jquery-ui"])) {
	$estilo[$indice++]='jquery-ui.css';
}

foreach ($estilo as $nombre){
	echo "<link rel='stylesheet' type='text/css' href='".$host.$sitio."/theme/basico/css/".$nombre."'>\n";	
	
}
?>