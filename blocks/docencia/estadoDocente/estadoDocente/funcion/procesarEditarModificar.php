<?
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
$conexion = "docencia2";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
$cadena_sql = $this->sql->cadena_sql ( "Consultar Estado Docente", $_REQUEST ['datos'] );
$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );

$datosConfirmar = array (
		"EstadoActual" => $resultado [0] ['estado'],
		"EstadoComplementario" => $resultado [0] ['estadocomplentario'],
		"DocumentoSoporte" => $resultado [0] ['documentosoporte'],
		"FechaInicio" => $resultado [0] ['fechainicio'],
		"FechaTerminacion" => $resultado [0] ['fechaterminacion'] 
);

if ($_REQUEST ['seleccionEstado'] == 1) {
	

	if ($datosConfirmar ['DocumentoSoporte'] != null) {
			
		
		$datos = array (
					
				'EstadoDoc' => $_REQUEST ['seleccionEstado'],
				'EstadoComplementario' => $_REQUEST ['seleccionEstadoComplemetario'],
				'DocumentoSoporte' => $datosConfirmar ['DocumentoSoporte'],
				'fechaInicio' => $_REQUEST ['fechaInicioE'],
				'fechaTerminacion' => $_REQUEST ['fechaTerminacionE'],
				'fechaRegistro' => date ( "Y-m-d" ),
				'docente' => $_REQUEST ['datos']
		);
		
		$conexion = "docencia2";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		$cadena_sql = $this->cadena_sql = $this->sql->cadena_sql ( "Corregir  Documento Soporte Estado", $_REQUEST ['DocumentoSoporte'], $datosConfirmar ['DocumentoSoporte'] );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
		
		$conexion = "docencia2";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		$cadena_sql = $this->cadena_sql = $this->sql->cadena_sql ( "Corregir Estado Docente", $datos );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
		
		
		
	} else {
		
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
		
		
		$datos = array (
					
				'EstadoDoc' => $_REQUEST ['seleccionEstado'],
				'EstadoComplementario' => $_REQUEST ['seleccionEstadoComplemetario'],
				'DocumentoSoporte' => $iddocumento,
				'fechaInicio' => $_REQUEST ['fechaInicioE'],
				'fechaTerminacion' => $_REQUEST ['fechaTerminacionE'],
				'fechaRegistro' => date ( "Y-m-d" ),
				'docente' => $_REQUEST ['datos']
		);
		
		
		
		$conexion = "docencia2";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		$cadena_sql = $this->cadena_sql = $this->sql->cadena_sql ( "Corregir Estado Docente", $datos );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
		
		
	}
	
	
} else {
	
	$datos = array (
			
			'EstadoDoc' => $_REQUEST ['seleccionEstado'],
			'fechaRegistro' => date ( "Y-m-d" ),
			'docente' => $_REQUEST ['datos'] 
	);
	
	$conexion = "docencia2";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	$cadena_sql = $this->cadena_sql = $this->sql->cadena_sql ( "Corregir Estado Docente Inactivo", $datos );
	$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
}

$mensaje = "Se creó la solicitud exitosamente.";
$error = "exito";

$datos = array (
		"mensaje" => $mensaje,
		"error" => $error 
);
$this->redireccionar ( "mostrarMensajeCorreccion", $datos );
?>
