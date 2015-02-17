<?php

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	
	$miSesion = Sesion::singleton ();
	
	$conexion = "estructura";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	
	$arregloDatos = array (
			$_REQUEST ['idInterpretacion'],
			$_REQUEST ['tituloInterpretacion'],
			$_REQUEST ['entidad'],
			$_REQUEST ['numPresentacion'],
			$_REQUEST ['fechPresentacion'],
			$_REQUEST ['autorPresentacion'],
			$_REQUEST ['numeActa'],
			$_REQUEST ['fechaActa'],
			$_REQUEST ['numeCaso'],
			$_REQUEST ['puntaje'] 
	);
	

	
	$this->cadena_sql = $this->sql->cadena_sql ( "actualizarIntepretacion", $arregloDatos );
	$resultado = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
	
	

	$arregloLogEvento = array (
			'registrar_interpretaciones',
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
	
	
	
	if ($resultado) {
		$this->funcion->redireccionar ( 'Actualizo', $_REQUEST ['idInterpretacion'] );
	} else {
		$this->funcion->redireccionar ( 'noActualizo', $_REQUEST ['idInterpretacion'] );
	}
}

?>