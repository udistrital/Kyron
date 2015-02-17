<?php

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	
	$miSesion = Sesion::singleton ();
	
	
	$arregloDatos = array (
			$_REQUEST ['idResena'],
			$_REQUEST ['titulo_resena'],
			$_REQUEST ['nombre_revista'],
			$_REQUEST ['categoria_revista'],
			$_REQUEST ['fecha_critica'],
			$_REQUEST ['autor_critica'],
			$_REQUEST ['numeActa'],
			$_REQUEST ['fechaActa'],
			$_REQUEST ['numeCaso'],
			$_REQUEST ['puntaje_resena']
	);
	

	
	
	
	$conexion = "estructura";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	$cadena_sql = $this->sql->cadena_sql ( "actualizarResena", $arregloDatos );
	
	$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
	
	$arregloLogEvento = array (
			'registrar_resena',
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
		$this->funcion->redireccionar ( 'Actualizo', $_REQUEST ['idResena'] );
	} else {
		$this->funcion->redireccionar ( 'noActualizo', $_REQUEST ['registrar_resena'] );
	}
}

?>