<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	
	$fechaActual = date ( 'Y-m-d' );
	
	$miSesion = Sesion::singleton ();
	$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
	
	$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "raizDocumento" ) . "/blocks/docencia/";
	$rutaBloque .= $esteBloque ['nombre'];
	$host = $this->miConfigurador->getVariableConfiguracion ( "host" ) . $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/docencia/" . $esteBloque ['nombre'];
	
	$conexion = "estructura";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	
	if (isset ( $_REQUEST ['actualizarDoc'] ) && $_REQUEST ['actualizarDoc'] == 2) {
		if ($_FILES) {
			// obtenemos los datos del archivo
			$tamano = $_FILES ["DocumentoSoporte"] ['size'];
			$tipo = $_FILES ["DocumentoSoporte"] ['type'];
			$archivo1 = $_FILES ["DocumentoSoporte"] ['name'];
			$prefijo = substr ( md5 ( uniqid ( rand () ) ), 0, 6 );
			
			if ($archivo1 != "") {
				// guardamos el archivo a la carpeta files
				$destino1 = $rutaBloque . "/archivoSoporte/" . $prefijo . "_" . $archivo1;
				if (copy ( $_FILES ['DocumentoSoporte'] ['tmp_name'], $destino1 )) {
					$status = "Archivo subido: <b>" . $archivo1 . "</b>";
					$destino1 = $host . "/archivoSoporte/" . $prefijo . "_" . $archivo1;
				} else {
					$status = "Error al subir el archivo";
				}
			} else {
				$status = "Error al subir archivo";
			}
		}
		
		$arregloDatos = array (
				$_REQUEST ['idEstado'],
				$_REQUEST ['seleccionEstado'],
				$_REQUEST ['seleccionEstadoComplemetario'],
				$_REQUEST ['fechaInicioE'],
				$_REQUEST ['fechaTerminacionE'],
				$destino1,
				$archivo1,
				$fechaActual 
		);
	} else {
		$arregloDatos = array (
				$_REQUEST ['idEstado'],
				$_REQUEST ['seleccionEstado'],
				$_REQUEST ['seleccionEstadoComplemetario'],
				$_REQUEST ['fechaInicioE'],
				$_REQUEST ['fechaTerminacionE'],
				$_REQUEST ['rutaSoporte'],
				$_REQUEST ['nombreSoporte'],
				$fechaActual 
		);
	}
	

	
	$this->cadena_sql = $this->sql->cadena_sql ( "Actualizar Estado Docente", $arregloDatos );
	$resultadoExperiencia = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
	$arregloLogEvento = array (
			'docente_estado',
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
	
	if ($resultadoExperiencia) {
		$this->funcion->redireccionar ( 'Actualizo', $_REQUEST ['identificacion'] );
	} else {
		$this->funcion->redireccionar ( 'noActualizo', $_REQUEST ['identificacion'] );
	}
}
?>