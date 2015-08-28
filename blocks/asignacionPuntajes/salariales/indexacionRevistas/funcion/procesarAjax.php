<?php
use asignacionPuntajes\salariales\indexacionRevistas\Sql;

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
?>