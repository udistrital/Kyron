<?php

$indice=0;

//Si se crea una variable en el arreglo llamado embebido dicha función no se enlaza como un archivo
//sino que se coloca como un bloque script

$funcion[$indice++]="jquery.easing.1.3.js";
$funcion[$indice++]="jquery.animate-colors-min.js";
$funcion[$indice++]="jquery.skitter.min.js";


$rutaBloque=$this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site");

if($unBloque["grupo"]==""){
	$rutaBloque.="/blocks/".$unBloque["nombre"];
}else{
	$rutaBloque.="/blocks/".$unBloque["grupo"]."/".$unBloque["nombre"];
}


foreach ($funcion as $clave=>$nombre){
	if(!isset($embebido[$clave])){
		echo "<script type='text/javascript' src='".$rutaBloque."/script/".$nombre."'></script>\n";
	}else{
		echo "<script type='text/javascript'>";
		include($nombre);
		echo "</script>\n";
	}
}

?>
