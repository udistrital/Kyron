<?php
if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{

	$miSesion = Sesion::singleton();

	$conexion="estructura";
	$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

	$arregloDatos = array($_REQUEST['idEstudio'],
			$_REQUEST['titulo_otorgado'],
			$_REQUEST['fechaObtencion'],
			$_REQUEST['universidad'],
			$_REQUEST['duracionDoctorado'],
			$_REQUEST['numeActa'],
			$_REQUEST['fechaActa'],
			$_REQUEST['numeCaso'],
			$_REQUEST['puntaje'],
			$_REQUEST['detalleDocencia']
                );

	$estudios = $this->cadena_sql = $this->sql->cadena_sql("actualizarEstudios", $arregloDatos);
	$resultadoPostdoctor = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "acceso");
	
	
	$arregloLogEvento = array (
			'estudiosdoctorales',
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
		
	if ($resultadoPostdoctor) {
		$this->funcion->redireccionar ( 'Actualizo', $_REQUEST ['idEstudio'] );
	} else {
		$this->funcion->redireccionar ( 'noActualizo', $_REQUEST ['idEstudio'] );
	}
}
?>