<?php
// var_dump($_REQUEST);
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	
	$miSesion = Sesion::singleton ();
	
	$conexion = "estructura";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	
	if ($_REQUEST ['pais'] && $_REQUEST ['pais'] != '-1') {

		if (isset ( $_REQUEST ['entidad'] ) && $_REQUEST ['entidad'] != - 1) {
			
			$arregloDatos = array (
					$_REQUEST ['idpremios'],
					$_REQUEST ['entidad'],
					$_REQUEST ['otraEntidad'] = 'NULL',
					$_REQUEST ['tipo_entidad'],
					$_REQUEST ['contexto_entidad'],
					$_REQUEST ['concepto'],
					$_REQUEST ['ciudad'],
					$_REQUEST ['pais'],
					$_REQUEST ['fechaPremio'],
					$_REQUEST ['numePersonas'],
					$_REQUEST ['yearPrize'],
					$_REQUEST ['numeActa'],
					$_REQUEST ['fechaActa'],
					$_REQUEST ['numeCaso'],
					$_REQUEST ['puntaje'], 
					$_REQUEST ['detalleDocencia'] 
			);
		} else if (isset ( $_REQUEST ['otraEntidad'] ) && $_REQUEST ['entidad'] == - 1) {
			
			$arregloDatos = array (
					$_REQUEST ['idpremios'],
					$_REQUEST ['entidad'] = "0",
					$_REQUEST ['otraEntidad'],
					$_REQUEST ['tipo_entidad'],
					$_REQUEST ['contexto_entidad'],
					$_REQUEST ['concepto'],
					$_REQUEST ['ciudad'],
					$_REQUEST ['pais'],
					$_REQUEST ['fechaPremio'],
					$_REQUEST ['numePersonas'],
					$_REQUEST ['yearPrize'],
					$_REQUEST ['numeActa'],
					$_REQUEST ['fechaActa'],
					$_REQUEST ['numeCaso'],
					$_REQUEST ['puntaje'], 
					$_REQUEST ['detalleDocencia']
			);
		}
	} else if ($_REQUEST ['pais'] == '' || $_REQUEST ['pais'] == '-1') {
		
		if (isset ( $_REQUEST ['entidad'] ) && $_REQUEST ['entidad'] != - 1) {

			$arregloDatos = array (
					$_REQUEST ['idpremios'],
					$_REQUEST ['entidad'],
					$_REQUEST ['otraEntidad'] = 'NULL',
					$_REQUEST ['tipo_entidad'],
					$_REQUEST ['contexto_entidad'],
					$_REQUEST ['concepto'],
					$_REQUEST ['ciudad'] = $_REQUEST ['ciudad1'],
					$_REQUEST ['pais'] = 'COL',
					$_REQUEST ['fechaPremio'],
					$_REQUEST ['numePersonas'],
					$_REQUEST ['yearPrize'],
					$_REQUEST ['numeActa'],
					$_REQUEST ['fechaActa'],
					$_REQUEST ['numeCaso'],
					$_REQUEST ['puntaje'], 
					$_REQUEST ['detalleDocencia'] 
			);
		} else if (isset ( $_REQUEST ['otraEntidad'] ) && $_REQUEST ['entidad'] == - 1) {
			
			$arregloDatos = array (
					$_REQUEST ['idpremios'],
					$_REQUEST ['entidad'] = "0",
					$_REQUEST ['otraEntidad'],
					$_REQUEST ['tipo_entidad'],
					$_REQUEST ['contexto_entidad'],
					$_REQUEST ['concepto'],
					$_REQUEST ['ciudad'] = $_REQUEST ['ciudad1'],
					$_REQUEST ['pais'] = 'COL',
					$_REQUEST ['fechaPremio'],
					$_REQUEST ['numePersonas'],
					$_REQUEST ['yearPrize'],
					$_REQUEST ['numeActa'],
					$_REQUEST ['fechaActa'],
					$_REQUEST ['numeCaso'],
					$_REQUEST ['puntaje'], 
					$_REQUEST ['detalleDocencia'] 
			);
		}
	}
	
	// var_dump($arregloDatos);
	$id_premio = $_REQUEST ['idpremios'];
	
	$sql = $this->cadena_sql = $this->sql->cadena_sql ( "actualizarPremios", $arregloDatos );
	
	$resultadoPonencia = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
	
	$arregloLogEvento = array (
			'premios_docente',
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
		$this->funcion->redireccionar ( 'Actualizo', $_REQUEST ['idpremios'] );
	} else {
		$this->funcion->redireccionar ( 'noActualizo', $_REQUEST ['idpremios'] );
	}
}

?>