<?php
$indice=0;
$estilo[$indice++]="dataTable/demo_page.css";
$estilo[$indice++]="dataTable/demo_table.css";
$estilo[$indice++]="dataTable/demo_table_jui.css";
$estilo[$indice++]="dataTable/jquery.dataTables.css";
$estilo[$indice++]="dataTable/jquery.dataTables_themeroller.css";
$estilo[$indice++]="search/jquery.liveSearch.css";//Live Search. Buscador
//<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.13.custom.css" rel="stylesheet" />
//$estilo[$indice++]="ui-lightness/jquery-ui-1.8.13.custom.css";


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