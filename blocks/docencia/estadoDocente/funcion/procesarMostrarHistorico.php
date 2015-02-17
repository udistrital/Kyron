<?


if (isset ( $datos ['seleccionnumerocedula'] )) {

	$Consulta = $datos ['seleccionnumerocedula'];

} else if (isset ( $datos ['selecciondocente1'] )) {

	$Consulta = $datos ['selecciondocente1'];

} else if (isset ( $datos ['selecciondocente2'] )) {

	$Consulta = $datos ['selecciondocente2'];

}else if (isset ( $datos ['selecciondocente3'] )) {

	$Consulta = $datos ['selecciondocente3'];

}else if (isset ( $datos ['selecciondocente4'] )) {

	$Consulta = $datos ['selecciondocente4'];

}


$conexion = "docencia2";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
$cadena_sql = $this->cadena_sql = $this->sql->cadena_sql ( "Consultar Historico Docente", $Consulta );
$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );



	if ($resultado == false) {
		echo "Se presentó un error en el sistema, contacte al administrador";
		exit ();
	}
	
	
	if ($resultado == true) {

		$this->funcion->redireccionar ( "historico",$Consulta);
	} else {
		echo "OOOPS!!!!. DB Engine Access Error";
		exit ();
	}

?>