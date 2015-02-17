<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	$miSesion = Sesion::singleton ();
	
	$conexion = "estructura";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	if (isset ( $_REQUEST ['entidad'] ) && $_REQUEST ['entidad'] != - 1) {
	
		$arregloDatos = array (
				$_REQUEST ['idExperiencia'],
				$_REQUEST ['entidad'],
				$_REQUEST ['otraEntidad'] = 'NULL',
				$_REQUEST ['tipo_entidad'],
				$_REQUEST ['numeHoras'],
				$_REQUEST ['fechaInicio'],
				$_REQUEST ['fechaFinal'],
				$_REQUEST ['duracion'],
				$_REQUEST ['numeActa'],
				$_REQUEST ['fechaActa'],
				$_REQUEST ['numeCaso'],
				$_REQUEST ['puntaje'],
				$_REQUEST ['detalleDocencia']
		);
	} else if (isset ( $_REQUEST ['otraEntidad'] ) && $_REQUEST ['entidad'] == - 1) {
	
		$arregloDatos = array (
				$_REQUEST ['idExperiencia'],
				$_REQUEST ['entidad'] = "0",
				$_REQUEST ['otraEntidad'],
				$_REQUEST ['tipo_entidad'],
				$_REQUEST ['numeHoras'],
				$_REQUEST ['fechaInicio'],
				$_REQUEST ['fechaFinal'],
				$_REQUEST ['duracion'],
				$_REQUEST ['numeActa'],
				$_REQUEST ['fechaActa'],
				$_REQUEST ['numeCaso'],
				$_REQUEST ['puntaje'],
				$_REQUEST ['detalleDocencia']
		);
	}
	
	
	
	{
	
		$cadena_sql = $this->sql->cadena_sql ( "actualizarExperiencia", $arregloDatos );
	
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
	
		$arregloLogEvento = array (
				'experiencia_direccion_acade',
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
			$this->funcion->redireccionar ( 'Actualizo', $_REQUEST ['idExperiencia'] );
		} else {
			$this->funcion->redireccionar ( 'noActualizo', $_REQUEST ['idExperiencia'] );
		}
	}
}
?>