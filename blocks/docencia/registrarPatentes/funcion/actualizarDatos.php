<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	
	$miSesion = Sesion::singleton ();
	
	$conexion = "estructura";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	
	$arregloDatos = array (
			$_REQUEST ['idPatente'],
			$_REQUEST ['tituloPatente'],
			$_REQUEST ['tipoPatente'],
			$_REQUEST ['entidadPatente'],
			$_REQUEST ['paisPatente'],
			$_REQUEST ['añoPatente'],
			$_REQUEST ['conceptoPatente'],
			$_REQUEST ['numeroRegistro'],
			$_REQUEST ['numeroActa'],
			$_REQUEST ['numeroCaso'],
			$_REQUEST ['fechaActa'],
			$_REQUEST ['puntaje'], 
			$_REQUEST ['detalleDocencia'] 
	);
	
	$this->cadena_sql = $this->sql->cadena_sql ( "actualizarPatente", $arregloDatos );
	$resultadoPonencia = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
	
	$arregloLogEvento = array (
			'registrar_patentes',
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
	
	if ($resultadoPonencia) {
		$this->funcion->redireccionar ( 'Actualizo', $_REQUEST ['idPatente'] );
	} else {
		$this->funcion->redireccionar ( 'noActualizo', $_REQUEST ['idPatente'] );
	}
}
?>