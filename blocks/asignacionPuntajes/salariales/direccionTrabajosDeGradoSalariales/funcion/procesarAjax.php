<?php
use asignacionPuntajes\salariales\direccionTrabajosDeGrado\Sql;

$miConfigurador = \Configurador::singleton ();
$miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		
//Estas funciones se llaman desde ajax.php y estas a la vez realizan las consultas de Sql.class.php 

//Esta Función es la que permite ir realizando las consultas a medida que se van ingresando caracteres ya sean números o letras en el campo docentes.

if ($_REQUEST ['funcion'] == 'consultarDocente') {
	
	$conexion = "docencia";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	
	$cadenaSql = $this->sql->getCadenaSql ( 'docente', $_GET ['query'] );
	$resultadoItems = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
	echo '{"suggestions":' . json_encode ( $resultadoItems ) . '}';
}

if ($_REQUEST ['funcion'] == 'consultarTrabajoGrado') {
	$param = $_GET ['query'];
	//https://github.com/astaxie/beego/blob/bf5c5626ab429e66d88602e1ab1ab5fbf4629a01/orm/db.go#L38
	//$response = file_get_contents('http://10.20.0.254/polux_api_crud/v1/trabajo_grado?query=Titulo.contains:' . $param);
	$polux_api_trabajo_grado = $miConfigurador->getVariableConfiguracion ( 'polux_api_trabajo_grado' );
	$response = @file_get_contents($polux_api_trabajo_grado . '?query=Titulo.icontains:' . $param);
	if($response === FALSE) { // handle error here... 
		echo '{"error":"No consigo conectarme con Polux"}';
		exit();
	}
	//$response = file_get_contents('http://10.20.0.254/polux_api_crud/v1/trabajo_grado');
	$response = json_decode($response);
	$resultadoItems = array();
	foreach ($response as $key => $value) {
		$item = array('data' => $value->{'Id'}, 'value' => $value->{'Titulo'});
		$resultadoItems[] = $item;
	}
	echo '{"suggestions":' . json_encode ( $resultadoItems ) . '}';
}


?>