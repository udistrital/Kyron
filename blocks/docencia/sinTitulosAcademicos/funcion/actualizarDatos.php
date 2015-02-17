<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	
	$miSesion = Sesion::singleton ();
	
	$conexion = "estructura";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
                
        $arregloDatos = array($_REQUEST['id_sintitulo'],
                              $_REQUEST['numeActa'],
                              $_REQUEST['fechaActa'],
                              $_REQUEST['numeCaso'],
                              $_REQUEST['categoria'],
                              $_REQUEST['puntaje'],
                              $_REQUEST['identificacion'],            
                              $_REQUEST['detalleDocencia']);            
        
        
	$sql = $this->cadena_sql = $this->sql->cadena_sql ( "actualizarSinTitulo", $arregloDatos );	
	$resultadoTitulos = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
	
	$arregloLogEvento = array (
			'sin_titulos_academicos',
			$arregloDatos,
			$miSesion->getSesionUsuarioId(),
			$_SERVER ['REMOTE_ADDR'],
			$_SERVER ['HTTP_USER_AGENT']
	);
	
	$argumento = json_encode ( $arregloLogEvento );
	$arregloFinalLogEvento = array($miSesion->getSesionUsuarioId(), $argumento);
	
	$cadena_sql = $this->sql->cadena_sql ( "registrarEvento", $arregloFinalLogEvento );
	$registroAcceso = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
	
	if ($resultadoTitulos) {
    
            $this->funcion->redireccionar ( 'Actualizo', $_REQUEST ['identificacion'] );    
                
	} else {
		$this->funcion->redireccionar ( 'noActualizo', $_REQUEST ['identificacion'] );
	}
}

?>