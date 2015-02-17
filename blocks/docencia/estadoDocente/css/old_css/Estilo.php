<?php
$indice=0;

$estilo[$indice++]="jquery-ui.css";
$estilo[$indice++]="ui.jqgrid.css";

//Se coloca esta condición para evitar cargar algunas hojas de estilo en el formulario de confirmación de entrada de datos.
if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){
	$estilo[$indice++]="jquery-te.css";
	$estilo[$indice++]="validationEngine.jquery.css";
	$estilo[$indice++]="autocomplete.css";
	$estilo[$indice++]="chosen.css";
	$estilo[$indice++]="select2.css";
}

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
