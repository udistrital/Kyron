<?
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	
	// 1. Borrar todos los registros que pertenezcan a la misma sesion
	//$variable ["fecha"] = time ();
	 $variable ["fecha"] = 123;
	if (! isset ( $configuracion ["id_sesion"] ) || $configuracion ["id_sesion"] == 0) {
		$configuracion ["id_sesion"] = $variable ["fecha"];
	}
	
	$cadena_sql = $this->sql->cadena_sql ( "eliminarTemp", $configuracion ["id_sesion"] );
	
	/**
	 * La conexiòn que se debe utilizar es la principal de SARA
	 */
	$conexion = "configuracion";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );

	
	// 2. Insertar Borrador
	$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
	
	$variable ["formulario"] = $esteBloque ["nombre"];
	
	$cadena_sql = $this->sql->cadena_sql ( "insertarTemp", $variable );
	
	$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );

	
	if ($resultado == false) {
		echo "Se presentó un error en el sistema, contacte al administrador";
		exit ();
	}
	$cadena_sql = $this->sql->cadena_sql ( "rescatarTemp", "123" );
	$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );
	
	if ($resultado == true) {
		
		$this->funcion->redireccionar ( "confirmar", "" );
	} else {
		echo "OOOPS!!!!. DB Engine Access Error";
		exit ();
	}
}
?>