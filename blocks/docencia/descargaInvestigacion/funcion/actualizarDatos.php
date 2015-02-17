<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	
	$miSesion = Sesion::singleton ();
	
	$conexion = "estructura";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	
	$arregloDatos = array (
			$_REQUEST ['idDescarga'],
			$_REQUEST ['dependenciaDescarga'],
			$_REQUEST ['horasDescarga'],
			$_REQUEST ['codigoDescarga'],
			$_REQUEST ['numeActa'] 
	);
	
	$solution = $this->cadena_sql = $this->sql->cadena_sql ( "actualizarDescarga", $arregloDatos );
	$resultadoDescarga = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
	
	$arregloLogEvento = array (
			'descarga_investigacion',
			$arregloDatos,
			$miSesion->getSesionUsuarioId (),
			$_SERVER ['REMOTE_ADDR'],
			$_SERVER ['HTTP_USER_AGENT'] 
	);
	
	$argumento = json_encode ( $arregloLogEvento );
	$arregloFinalLogEvento = array (
			$miSesion->getSesionUsuarioId (),
			$argumento 
	);
	
	$cadena_sql = $this->sql->cadena_sql ( "registrarEvento", $arregloFinalLogEvento );
	$registroAcceso = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
	
	if ($resultadoDescarga) {
		$this->funcion->redireccionar ( 'Actualizo', $_REQUEST ['idDescarga'] );
	} else {
		$this->funcion->redireccionar ( 'noActualizo', $_REQUEST ['idDescarga'] );
	}
}

?>