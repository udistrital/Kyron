<?php
$indice=0;
$estilo[$indice++]="jquery-ui.css";
$estilo[$indice++]="jquery-ui.theme.css";
$estilo[$indice++]="jquery-te.css";
$estilo[$indice++]="validationEngine.jquery.css";
$estilo[$indice++]="autocomplete.css";
$estilo[$indice++]="ui.jqgrid.css";
$estilo[$indice++]="chosen.css";
$estilo[$indice++]="mensajes/mensajes.css";

$rutaBloque=$this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site");

if($unBloque["grupo"]==""){
	$rutaBloque.="/blocks/".$unBloque["nombre"];
}else{
	$rutaBloque.="/blocks/".$unBloque["grupo"]."/".$unBloque["nombre"];
}

foreach ($estilo as $nombre){
	echo "<link rel='stylesheet' type='text/css' href='".$rutaBloque."/css/".$nombre."'>\n";

}
?>

