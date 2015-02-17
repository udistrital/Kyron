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
				$_REQUEST ['idExperiencia'],
				$_REQUEST ['entidad'],
				$_REQUEST ['cargo'],
				$_REQUEST ['fechaInicio'],
				$_REQUEST ['fechaFin'],
				$_REQUEST ['numeActa'],
				$_REQUEST ['fechaActa'],
				$_REQUEST ['numeCaso'],
				$_REQUEST ['duracion'],
				$_REQUEST ['puntaje'],
				$_REQUEST ['otraEntidad'] = 'NULL' ,
				$_REQUEST ['detalleDocencia']
		);
	} else {
		
		$arregloDatos = array (
				$_REQUEST ['idExperiencia'],
				$_REQUEST ['entidad']='0',
				$_REQUEST ['cargo'],
				$_REQUEST ['fechaInicio'],
				$_REQUEST ['fechaFin'],
				$_REQUEST ['numeActa'],
				$_REQUEST ['fechaActa'],
				$_REQUEST ['numeCaso'],
				$_REQUEST ['duracion'],
				$_REQUEST ['puntaje'],
				$_REQUEST ['otraEntidad'],
				$_REQUEST ['detalleDocencia'] 
		);
	}
	

	$this->cadena_sql = $this->sql->cadena_sql ( "actualizarProfesion", $arregloDatos );
	$resultadoInvestigacion = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
	
	$arregloLogEvento = array (
			'experiencia_profesional',
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
		$this->funcion->redireccionar ( 'Actualizo', $_REQUEST ['idExperiencia'] );
	} else {
		$this->funcion->redireccionar ( 'noActualizo', $_REQUEST ['idExperiencia'] );
	}
}
?>