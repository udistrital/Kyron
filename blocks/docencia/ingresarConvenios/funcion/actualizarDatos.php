<?php


if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	
	$miSesion = Sesion::singleton ();
	
	$conexion = "estructura";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	
	if ($_REQUEST ['actualizarDoc'] == 1) {
		
		$arregloDatos = array (
				$_REQUEST ['idConvenio'],
				$_REQUEST ['nombre_convenio'],
				$_REQUEST ['monto_convenio'],
				$_REQUEST ['rol_docente'],
				$_REQUEST ['ruta'],
				$_REQUEST ['nombre'] 
		);
	} else if ($_REQUEST ['actualizarDoc'] == 2) {
		
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
		$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "raizDocumento" ) . "/blocks/docencia/";
		$rutaBloque .= $esteBloque ['nombre'];
		$host = $this->miConfigurador->getVariableConfiguracion ( "host" ) . $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/docencia/" . $esteBloque ['nombre'];
		
		if ($_FILES) {
			// obtenemos los datos del archivo
			$tamano = $_FILES ["documento_soporte"] ['size'];
			$tipo = $_FILES ["documento_soporte"] ['type'];
			$archivo1 = $_FILES ["documento_soporte"] ['name'];
			$prefijo = substr ( md5 ( uniqid ( rand () ) ), 0, 6 );
			
			if ($archivo1 != "") {
				// guardamos el archivo a la carpeta files
				$destino1 = $rutaBloque . "/archivos_respaldo/" . $prefijo . "_" . $archivo1;
				if (copy ( $_FILES ['documento_soporte'] ['tmp_name'], $destino1 )) {
					$status = "Archivo subido: <b>" . $archivo1 . "</b>";
					$destino1 = $host . "/archivos_respaldo/" . $prefijo . "_" . $archivo1;
					
					// echo $status;exit;
				} else {
					$status = "Error al subir el archivo";
				}
			} else {
				$status = "Error al subir archivo";
			}
		}
		
		$arregloDatos = array (
				$_REQUEST ['idConvenio'],
				$_REQUEST ['nombre_convenio'],
				$_REQUEST ['monto_convenio'],
				$_REQUEST ['rol_docente'],
				$destino1,
				$archivo1 
		);
	}
	
	
	$sql = $this->cadena_sql = $this->sql->cadena_sql ( "actualizarConvenio", $arregloDatos );
	
	$resultadoObra = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
	
	$arregloLogEvento = array (
			'convenios',
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
	
	if ($resultadoObra) {
		$this->funcion->redireccionar ( 'Actualizo', $_REQUEST ['idConvenio'] );
	} else {
		$this->funcion->redireccionar ( 'noActualizo', $_REQUEST ['idConvenio'] );
	}
}

?>
