<?

// echo "procesar editar esatdo";
// var_dump($_REQUEST);
function validarerror($resultado) {
	if ($resultado == true) {
		$mensaje = "Se creó la solicitud exitosamente.";
		echo $mensaje;
		$error = "exito";
	} else {
		$mensaje = "...Oops, se ha presentado un error en el sistema, por favor contacte al administrador del sistema";
		$error = "error";
	}
	
	$datos = array (
			"mensaje" => $mensaje,
			"error" => $error 
	);
	return $datos;
}

// var_dump($_REQUEST);exit;

if ($_REQUEST ['seleccionEstado'] == 1) {
	$variableDocumento = array (
			"nombre" => $_REQUEST ['DocumentoSoporte'],
			"ruta" => 'usr/local/apache',
			"formato" => 'pdf',
			"Autor" => 'Michael Verdugo' 
	);
	
	$conexion = "docencia2";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	$cadena_sql = $this->cadena_sql = $this->sql->cadena_sql ( "Guardar Documento Soporte Estado", $variableDocumento );
	$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );
	$iddocumento = $resultado [0] ['identificador'];
	
	$conexion = "docencia2";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	$cadena_sql = $this->cadena_sql = $this->sql->cadena_sql ( "Actualizar Historico Estado", $_REQUEST ['datos'] );
	$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
	
	$datos = array (
			
			'EstadoDoc' => $_REQUEST ['seleccionEstado'],
			'EstadoComplementario' => $_REQUEST ['seleccionEstadoComplemetario'],
			'DocumentoSoporte' => $iddocumento,
			'fechaInicio' => $_REQUEST ['fechaInicioE'],
			'fechaTerminacion' => $_REQUEST ['fechaTerminacionE'],
			'fechaRegistro' => date ( "Y-m-d" ),
			'estadoRegistro' => 'true',
			'docente' => $_REQUEST ['datos'] 
	);
	

	
	$conexion = "docencia2";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	$cadena_sql = $this->cadena_sql = $this->sql->cadena_sql ( "GuardarEstadoDocente", $datos );
	$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
} else {
	
	$conexion = "docencia2";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	$cadena_sql = $this->cadena_sql = $this->sql->cadena_sql ( "Actualizar Historico Estado", $_REQUEST ['datos'] );
	$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
	
	$datos = array (
			
			'EstadoDoc' => $_REQUEST ['seleccionEstado'],
			'fechaRegistro' => date ( "Y-m-d" ),
			'estadoRegistro' => 'true',
			'docente' => $_REQUEST ['datos'] 
	);
	
	$conexion = "docencia2";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	$cadena_sql = $this->cadena_sql = $this->sql->cadena_sql ( "GuardarEstadoDocenteInactivo", $datos );
	$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
	

}
		$mensaje = "Se creó la solicitud exitosamente.";
		$error = "exito";

$datos = array (
		"mensaje" => $mensaje,
		"error" => $error 
);
$this->redireccionar ( "mostrarMensaje", $datos );
?>
