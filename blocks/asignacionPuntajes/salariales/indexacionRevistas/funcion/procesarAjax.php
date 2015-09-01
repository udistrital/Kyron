<?php
use asignacionPuntajes\salariales\indexacionRevistas\Sql;

$conexion = "docencia";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );

if ($_REQUEST ['funcion'] == 'consultarDocente') {
	$cadenaSql = $this->sql->getCadenaSql ( 'docente', $_GET ['query'] );
	$resultadoItems = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
	foreach ( $resultadoItems as $key => $values ) {
		$keys = array (
				'value',
				'data'
		);
		$resultado [$key] = array_intersect_key ( $resultadoItems [$key], array_flip ( $keys ) );
	}
	echo '{"suggestions":' . json_encode ( $resultado ) . '}';
}


if ($_REQUEST ['funcion'] == 'consultarPais') {
	$cadenaSql = $this->sql->getCadenaSql ( 'pais');
	$datos = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
	echo json_encode( $datos );
}

if ($_REQUEST ['funcion'] == 'consultarCategoria') {
	$cadenaSql = $this->sql->getCadenaSql ( 'categoria_revista', $_REQUEST["valor"]);
	$datos = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
	echo json_encode( $datos );
}
?>