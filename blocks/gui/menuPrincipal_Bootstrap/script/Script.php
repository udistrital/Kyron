<?php
/**
 * Importante: Este script es invocado desde la clase ArmadorPagina. La información del bloque se encuentra
 * en el arreglo $esteBloque. Esto también aplica para todos los archivos que se incluyan.
 *
 * CUANDO SE NECESITE REGISTRAR OPCIONES PARA LA FUNCIÓN ready DE JQuery, SE DEBE DECLARAR EN ARCHIVOS DENOMINADOS
 * ready.js o ready.php. DICHOS ARCHIVOS DEBEN IR EN LA CARPETA script DE LOS BLOQUES PERO NO RELACIONARSE AQUI. 
 */

/*
 * Este bloque necesita bootstrap para eso en la página escriba en la tabla de páginas en la columna "parametro"
 * bootstrap=true
 * ó bootstrap=3.3.5
 * ó bootstrap=3.3.5.min
 * o alguna otra versión que considere correspondiente
 */

// Registrar los archvos js que deben incluirse

//No son necesarios los scripts para el menú porque en los links de abajo se carga.
// $indice=0;
// $funcion[$indice++]='bootstrap.js';

// $rutaBloque=$this->miConfigurador->getVariableConfiguracion("host");
// $rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site");

// if($esteBloque["grupo"]==""){
// 	$rutaBloque.="/blocks/".$esteBloque["nombre"];
// }else{
// 	$rutaBloque.="/blocks/".$esteBloque["grupo"]."/".$esteBloque["nombre"];
// }


// foreach ($funcion as $clave=>$nombre){
// 	if(!isset($embebido[$clave])){
// 		echo "\n<script type='text/javascript' src='".$rutaBloque."/script/".$nombre."'>\n</script>\n";
// 	}else{
// 		echo "\n<script type='text/javascript'>";
// 		include($nombre);
// 		echo "\n</script>\n";
// 	}
// }

/**
 * Incluir los scripts que deben registrarse como javascript pero requieren procesamiento previo de código php
 */

//include("archivoPHP con código js embebido.php");


// Procesar las funciones requeridas en ajax
//include("ajax.php");

?>
