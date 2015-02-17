<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	
	$miSesion = Sesion::singleton ();
	
	$conexion = "estructura";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	
	$arregloDatos = array (
			$_REQUEST ['idAvance'],
			$_REQUEST ['razonAvance'],
			$_REQUEST ['numeroResolucion'],
			$_REQUEST ['fechaResolucion'],
			$_REQUEST ['montoAvance'],
			$_REQUEST ['fechaLegalizacion']  
	);
	
	$solution = $this->cadena_sql = $this->sql->cadena_sql ( "actualizarAvance", $arregloDatos );
	$resultadoAvance = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
	
	$arregloLogEvento = array (
			'avances_financieros',
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
	
	if ($resultadoAvance) {
		$this->funcion->redireccionar ( 'Actualizo', $_REQUEST ['idAvance'] );
	} else {
		$this->funcion->redireccionar ( 'noActualizo', $_REQUEST ['idAvance'] );
	}
}

?>