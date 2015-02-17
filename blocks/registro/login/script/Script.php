<?php
/**
 * Importante: Este script es invocado desde la clase ArmadorPagina. La información del bloque se encuentra
 * en el arreglo $esteBloque. Esto también aplica para todos los archivos que se incluyan.
 */




$indice=0;
$funcion[$indice++]="md5.js";
$funcion[$indice++]="jquery.validationEngine.js";
$funcion[$indice++]="jquery.validationEngine-es.js";
$funcion[$indice++]="jqueryui.js";


$rutaBloque=$this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site");

if($esteBloque["grupo"]==""){
	$rutaBloque.="/blocks/".$esteBloque["nombre"];
}else{
	$rutaBloque.="/blocks/".$esteBloque["grupo"]."/".$esteBloque["nombre"];
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
