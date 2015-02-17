<?php
/**
 * Importante: Este script es invocado desde la clase ArmadorPagina. La información del bloque se encuentra
 * en el arreglo $esteBloque. Esto también aplica para todos los archivos que se incluyan.
 */

// Registrar los archvios js que deben incluirse



$indice=0;
$funcion[$indice++]="jquery.validationEngine.js";
$funcion[$indice++]="jquery.validationEngine-es.js";
$funcion[$indice++]="jquery-te.js";
$funcion[$indice++]="jqueryui.js";
$funcion[$indice++]="datepicker_es.js";
$funcion[$indice++]="combobox.js";

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

/**
 * Incluir los scripts que deben registrarse como javascript pero requieren procesamiento previo de código php
 */
// JQgrid

//include("jqgrid.php");


// Procesar las funciones requeridas en ajax
include("Ajax.php");

?>
