<?php
$indice=0;
$estilo[$indice++]="dataTable/demo_page.css";
$estilo[$indice++]="dataTable/demo_table.css";
$estilo[$indice++]="dataTable/demo_table_jui.css";
$estilo[$indice++]="dataTable/jquery.dataTables.css";
$estilo[$indice++]="dataTable/jquery.dataTables_themeroller.css";


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