<?php

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	
		$miSesion = Sesion::singleton ();
	// var_dump($_REQUEST);exit;
	$conexion = "estructura";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	
	$arregloDatos = array (
			$_REQUEST ['idTraduccion'],
			$_REQUEST ['tituloTraduccion'],
			$_REQUEST ['nombreTraductor'],
			$_REQUEST ['fechaTraduccion'],
			$_REQUEST ['yearLibro'],
			$_REQUEST ['numeroActa'],
			$_REQUEST ['fechaActa'],
			$_REQUEST ['numeCaso'],
			$_REQUEST ['puntajeAsignado'],
			$_REQUEST ['volumenLibro']
	);
// 	var_dump($arregloDatos);	
	$sql=$this->cadena_sql = $this->sql->cadena_sql ( "actualizarTraduccion", $arregloDatos );
// 	echo $sql;exit;
	$resultadoTitulo = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
// 	echo $resultadoTitulo;exit;
	$arregloLogEvento = array (
			'registrar_traducciones',
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
		
	if ($resultadoTitulo) {
		$this->funcion->redireccionar ( 'Actualizo', $_REQUEST ['idTraduccion'] );
	} else {
		$this->funcion->redireccionar ( 'noActualizo', $_REQUEST ['idTraduccion'] );
	}
}

?>