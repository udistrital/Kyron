<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	
	$miSesion = Sesion::singleton ();
	
	$conexion = "estructura";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	
	if ($_REQUEST ['entidadCertifica'] != '') {
		$entidadCert = $_REQUEST ['entidadCertifica'];
	} else {
		$entidadCert = 'NULL';
	}
	
	$arregloDatos = array (
			$_REQUEST ['identificacionFinalCrear'],
			$_REQUEST ['titulolibro'],
			$_REQUEST ['tipo_libro'],
			$entidadCert,
			$_REQUEST ['codigo_numeracion'],
			$_REQUEST ['num_autores_libro'],
			$_REQUEST ['num_autores_libro_universidad'],
			$_REQUEST ['editorial'],
			$_REQUEST ['anio_libro'],
			$_REQUEST ['numeActa'],
			$_REQUEST ['fechaActa'],
			$_REQUEST ['numeCaso'],
			$_REQUEST ['puntaje'],
                        $_REQUEST ['detalleDocencia'] 
	);
	
	$this->cadena_sql = $this->sql->cadena_sql ( "insertarLibro", $arregloDatos );	
	$resultadoLibros = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "busqueda" );
	
	$arregloLogEvento = array (
			'registro_libros',
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
	
	if ($resultadoLibros) {
		for($j = 1; $j <= $_REQUEST ['numEvaluadores']; $j ++) {
			$arregloEvaluadores = array (
					$_REQUEST ['idenEvaluador' . $j],
					$_REQUEST ['nomEvaluador' . $j],
					$_REQUEST ['uniEvaluador' . $j],
					$_REQUEST ['puntEvaluador' . $j] 
			);
			$this->cadena_sql = $this->sql->cadena_sql ( "insertEva", $arregloEvaluadores, $resultadoLibros [0] [0] );
			$resultadoEvaluadores = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
			
			$arregloLogEvento = array (
					'revisores_lbros',
					$arregloEvaluadores,
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
		}
		
		$this->funcion->redireccionar ( 'inserto', $_REQUEST ['docente'] );
	} else {
		$this->funcion->redireccionar ( 'noInserto', $_REQUEST ['docente'] );
	}
}
?>