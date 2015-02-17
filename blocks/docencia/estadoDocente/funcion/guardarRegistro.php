<?php

// echo"llegamos guardar registro";exit;
$conexion = "docencia";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
$cadena_sql = $this->cadena_sql = $this->sql->cadena_sql ( "guardarRegistro", $datos );
// echo $cadena_sql;exit;
$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );

if ($resultado == true) {
	$mensaje = "Se creó la solicitud exitosamente.";
	$error = "exito";
} else {
	$mensaje = "...Oops, se ha presentado un error en el sistema, por favor contacte al administrador del sistema";
	$error = "error";
}

$datos = array (
		"mensaje" => $mensaje,
		"error" => $error 
);

$this->redireccionar ( "mostrarMensaje", $datos );
?>