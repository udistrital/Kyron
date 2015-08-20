<?php

use gui\bannerKyron\sql;

$conexion = "inventarios";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

if ($_REQUEST ['funcion'] == 'consultarDependencia') {

	$conexion = "sicapital";

	$esteRecursoDBO = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );


	$cadenaSql = $this->sql->getCadenaSql ( 'dependencias', $_REQUEST['valor'] );
	$resultado = $esteRecursoDBO->ejecutarAcceso ( $cadenaSql, "busqueda" );


	$resultado = json_encode ( $resultado);

	echo $resultado;
}

?>
