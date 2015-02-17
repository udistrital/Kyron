<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	
	$miSesion = Sesion::singleton ();
	
	$conexion = "estructura";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	
if ($_REQUEST ['entidad'] != - 1) {
			
		$arregloDatos = array (
				$_REQUEST ['idInvestigacion'],
				$_REQUEST ['entidad'],
				$_REQUEST ['otraEntidad'] = 'NULL',
				$_REQUEST ['experiencia'],
				$_REQUEST ['fechaInicio'],
				$_REQUEST ['fechaFin'],
				$_REQUEST ['numeActa'],
				$_REQUEST ['fechaActa'],
				$_REQUEST ['numeCaso'],
				$_REQUEST ['horas'],
				$_REQUEST ['puntaje'],
                                $_REQUEST ['detalleDocencia']
		);
	} else {
		
		$arregloDatos = array (
				$_REQUEST ['idInvestigacion'],
				$_REQUEST ['entidad']='0',
				$_REQUEST ['otraEntidad'],
				$_REQUEST ['experiencia'],
				$_REQUEST ['fechaInicio'],
				$_REQUEST ['fechaFin'],
				$_REQUEST ['numeActa'],
				$_REQUEST ['fechaActa'],
				$_REQUEST ['numeCaso'],
				$_REQUEST ['horas'],
				$_REQUEST ['puntaje'],
                                $_REQUEST ['detalleDocencia'] 
		);
	}
	
	$this->cadena_sql = $this->sql->cadena_sql ( "actualizarExperiencia", $arregloDatos );
	$resultadoInvestigacion = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
	
	$arregloLogEvento = array (
			'experiencia_investigacion',
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
	
	if ($resultadoInvestigacion) {
		$this->funcion->redireccionar ( 'Actualizo', $_REQUEST ['idInvestigacion'] );
	} else {
		$this->funcion->redireccionar ( 'noActualizo', $_REQUEST ['idInvestigacion'] );
	}
}
?>