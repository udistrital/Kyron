<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	
	$miSesion = Sesion::singleton ();
	
	$conexion = "estructura";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );

        if ($_REQUEST ['contexto_entidad'] == '1') {
		
		$arregloDatos = array (
				$_REQUEST ['idCarta'],
				$_REQUEST ['nombre_revista'],
				$_REQUEST ['contexto_entidad'],
				trim($_REQUEST ['pais']='COL'),
				$_REQUEST ['indexacion'],
				$_REQUEST ['institucion'],
				$_REQUEST ['ISSN'],
				$_REQUEST ['año'],
				$_REQUEST ['volumen'],
				$_REQUEST ['No'],
				$_REQUEST ['paginas'],
				$_REQUEST ['titulo_articulo'],
				$_REQUEST ['no_autores'],
				$_REQUEST ['autoresUD'],
				$_REQUEST ['fecha_publicacion'],
				$_REQUEST ['numeActa'],
				$_REQUEST ['fechaActa'],
				$_REQUEST ['numeCaso'],
				$_REQUEST ['puntaje'],
				$_REQUEST ['detalleDocencia']
		);
	} else {
		
		$arregloDatos = array (
				$_REQUEST ['idCarta'],
				$_REQUEST ['nombre_revista'],
				$_REQUEST ['contexto_entidad'],
				$_REQUEST ['pais'],
				trim($_REQUEST ['indexacionInternacional']),
				$_REQUEST ['institucion'],
				$_REQUEST ['ISSN'],
				$_REQUEST ['año'],
				$_REQUEST ['volumen'],
				$_REQUEST ['No'],
				$_REQUEST ['paginas'],
				$_REQUEST ['titulo_articulo'],
				$_REQUEST ['no_autores'],
				$_REQUEST ['autoresUD'],
				$_REQUEST ['fecha_publicacion'],
				$_REQUEST ['numeActa'],
				$_REQUEST ['fechaActa'],
				$_REQUEST ['numeCaso'],
				$_REQUEST ['puntaje'] ,
				$_REQUEST ['detalleDocencia']
		);
	}
	
	$id_carta = $_REQUEST ['idCarta'];	
	$this->cadena_sql = $this->sql->cadena_sql ( "actualizarCarta", $arregloDatos );
	$resultadoCarta = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
	
	$arregloLogEvento = array (
			'cartas_editor',
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
	
	if ($resultadoCarta) {
		$this->funcion->redireccionar ( 'Actualizo', $_REQUEST ['idCarta'] );
	} else {
		$this->funcion->redireccionar ( 'noActualizo', $_REQUEST ['idCarta'] );
	}
}

?>