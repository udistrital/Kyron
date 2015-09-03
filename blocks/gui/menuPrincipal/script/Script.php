<?php

$indice=0;
$funcion[$indice++]="jquery.dcmegamenu.1.3.3.js";
$funcion[$indice++]="jquery.dcmegamenu.1.3.3.min.js";
$funcion[$indice++]="jquery.hoverIntent.minified.js";

$rutaBloque=$this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site");

if($esteBloque["grupo"]==""){
	$rutaBloque.="/blocks/".$esteBloque["nombre"];
}else{
	$rutaBloque.="/blocks/".$esteBloque["grupo"]."/".$esteBloque["nombre"];
}

if(isset($funcion[0])){
foreach ($funcion as $clave=>$nombre){
	if(!isset($embebido[$clave])){
		echo "\n<script type='text/javascript' src='".$rutaBloque."/script/".$nombre."'>\n</script>\n";
	}else{
		echo "\n<script type='text/javascript'>";
		include($nombre);
		echo "\n</script>\n";
	}
}
}

?>


