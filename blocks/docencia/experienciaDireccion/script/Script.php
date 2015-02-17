<?php
/**
 * Importante: Este script es invocado desde la clase ArmadorPagina. La información del bloque se encuentra
 * en el arreglo $esteBloque. Esto también aplica para todos los archivos que se incluyan.
 */

// Registrar los archvios js que deben incluirse

$funcion=array();
$indice=0;
$funcion[$indice++]="jqueryui.js";
$funcion[$indice++]="jquery.validationEngine.js";
$funcion[$indice++]="jquery.validationEngine-es.js";
$funcion[$indice++]="jquery-te.js";
$funcion[$indice++]="select2.js";
$funcion[$indice++]="select2_locale_es.js";
$funcion[$indice++]="jquery.dataTables.js";
$funcion[$indice++]="jquery.dataTables.min.js";
$funcion[$indice++]="miScript.js";
//$funcion[$indice++]="jquery_switch.js";
$funcion[$indice++]="timepicker.js";


$rutaBloque=$this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site");

if($esteBloque["grupo"]==""){
	$rutaBloque.="/blocks/".$esteBloque["nombre"];
}else{
	$rutaBloque.="/blocks/".$esteBloque["grupo"]."/".$esteBloque["nombre"];
}


foreach ($funcion as $clave=>$nombre){
	if(!isset($embebido[$clave])){
		echo "\n<script type='text/javascript' src='".$rutaBloque."/script/".$nombre."'>\n</script>\n";
	}else{
		echo "\n<script type='text/javascript'>";
		include($nombre);
		echo "\n</script>\n";
	}
}
// Procesar las funciones requeridas en ajax
	include("Ajax.php");

?>