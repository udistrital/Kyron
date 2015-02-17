<?php
$indice=0;
$estilo[$indice++]="dcmegamenu.css";
$estilo[$indice++]="skins/black.css";
$estilo[$indice++]="skins/blue.css";
$estilo[$indice++]="skins/green.css";
$estilo[$indice++]="skins/grey.css";
$estilo[$indice++]="skins/light_blue.css";
$estilo[$indice++]="skins/orange.css";
$estilo[$indice++]="skins/red.css";
$estilo[$indice++]="skins/white.css";

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