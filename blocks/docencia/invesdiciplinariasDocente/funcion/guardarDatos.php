<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	$miSesion = Sesion::singleton ();
	$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
	
	$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "raizDocumento" ) . "/blocks/docencia/";
	$rutaBloque .= $esteBloque ['nombre'];
	
	$host = $this->miConfigurador->getVariableConfiguracion ( "host" ) . $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/docencia/" . $esteBloque ['nombre'];
	
	if ($_FILES) {
		// obtenemos los datos del archivo
		$tamano = $_FILES ["soporte"] ['size'];
		$tipo = $_FILES ["soporte"] ['type'];
		$archivo1 = $_FILES ["soporte"] ['name'];
		$prefijo = substr ( md5 ( uniqid ( rand () ) ), 0, 6 );
		
		if ($archivo1 != "") {
			// guardamos el archivo a la carpeta files
			$destino1 = $rutaBloque . "/archivoSoporte/" . $prefijo . "_" . $archivo1;
			if (copy ( $_FILES ['soporte'] ['tmp_name'], $destino1 )) {
				$status = "Archivo subido: <b>" . $archivo1 . "</b>";
				$destino1 = $host . "/archivoSoporte/" . $prefijo . "_" . $archivo1;
				
				// echo $status;exit;
			} else {
				$status = "Error al subir el archivo";
			}
		} else {
			$status = "Error al subir archivo";
		}
	}
	
	$conexion = "estructura";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	
	$arregloDatos = array (
			$_REQUEST ['docente'],
			$_REQUEST ['num_investig'],
			$_REQUEST ['descrip'],
			$destino1,
			$archivo1 
	);
	
	$this->cadena_sql = $this->sql->cadena_sql ( "insertarInvestigacion", $arregloDatos );
	$resultadoExperiencia = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
	$arregloLogEvento = array (
			'investigaciondic_docente',
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
		$this->funcion->redireccionar ( 'inserto', $_REQUEST ['docente'] );
	} else {
		$this->funcion->redireccionar ( 'noInserto', $_REQUEST ['docente'] );
	}
}
?>