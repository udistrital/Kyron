<?php
use asignacionPuntajes\salariales\capituloLibros\Sql;

$conexion = "docencia";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );


//Estas funciones se llaman desde ajax.php y estas a la vez realizan las consultas de Sql.class.php 

if ($_REQUEST ['funcion'] == 'consultarEntidadCertificadora') {
	$cadenaSql = $this->sql->getCadenaSql ( 'entidadCertificadora');
	$datos = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
	echo json_encode( $datos );
}

//Esta Función es la que permite ir realizando las consultas a medida que se van ingresando caracteres ya sean números o letras en el campo docentes.

if ($_REQUEST ['funcion'] == 'consultarDocente') {
	$cadenaSql = $this->sql->getCadenaSql ( 'docente', $_GET ['query'] );
	$resultadoItems = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
	echo '{"suggestions":' . json_encode ( $resultadoItems ) . '}';
}

?>