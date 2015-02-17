<?php
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

$conexion = "docencia";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );



$cadena_sql [1] = $this->cadena_sql = $this->sql->cadena_sql ( "guardarDocenteInformacion", $datos );
$cadena_sql [2] = $this->cadena_sql = $this->sql->cadena_sql ( "guardarDocenteInformacionInvariante", $datos );
$cadena_sql [3] = $this->cadena_sql = $this->sql->cadena_sql ( "guardarDocumentoResolucionVinculacion", $datos, $resolucion );
$cadena_sql [4] = $this->cadena_sql = $this->sql->cadena_sql ( "guardarVinculacionDocente", $datos );
$cadena_sql [5] = $this->cadena_sql = $this->sql->cadena_sql ( "guardarDocumentosVinculacionDocente", $datos, "", $documentos [1] );
$cadena_sql [6] = $this->cadena_sql = $this->sql->cadena_sql ( "guardarDocumentosVinculacionDocente", $datos, "", $documentos [2] );
$cadena_sql [7] = $this->cadena_sql = $this->sql->cadena_sql ( "guardarDocumentosVinculacionDocente", $datos, "", $documentos [3] );
$cadena_sql [8] = $this->cadena_sql = $this->sql->cadena_sql ( "guardarDependenciaDocente", $datos );
$cadena_sql [9] = $this->cadena_sql = $this->sql->cadena_sql ( "guardarCategoriaDocente", $datos );
$cadena_sql [10] = $this->cadena_sql = $this->sql->cadena_sql ( "guardarInformacionDetalladaDocente", $datos );
$cadena_sql [11] = $this->cadena_sql = $this->sql->cadena_sql ( "guardarNombramientoDocente", $datos );

foreach ( $cadena_sql as $k => $values ) {
	$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql [$k], "acceso" );
	if ($resultado !='false') {
		echo $resultado."<br>";
		$mensaje = "...Oops, se ha presentado un error en el sistema, por favor contacte al administrador del sistema";
		$error = "error";
	} else {
		
		$mensaje = "Se creó la solicitud exitosamente.";
		$error = "exito";
	}
}
$datos = array (
		"mensaje" => $mensaje,
		"error" => $error 
);
$this->redireccionar ( "mostrarMensaje", $datos );
?>