<?
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	
	$conexion = "configuracion";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	$cadena_sql = $this->sql->cadena_sql ( "rescatarTemp", "123" );
	$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );

if ($resultado == true) {
		
		$this->funcion->redireccionar ( "editar", "" );
	} else {
		echo "OOOPS!!!!. DB Engine Access Error";
		exit ();
	}
}
?>