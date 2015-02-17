<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	
	$miSesion = Sesion::singleton ();
	$conexion = "estructura";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	
	if ($_REQUEST ['tipo_traducc'] == '1') {
		
		$arregloDatos = array (
				$_REQUEST ['identificacionFinalCrear'],
				$_REQUEST ['titulo_publicacion'],
				$_REQUEST ['titulo_traduccion'],
				$_REQUEST ['revista'] = "NULL",
				$_REQUEST ['tipo_traducc'],
				$_REQUEST ['num_revista'] = "NULL",
				$_REQUEST ['volumen'] = "NULL",
				$_REQUEST ['anioR'] = "NULL",
				$_REQUEST ['tipo_revista'] = "NULL",
				$_REQUEST ['nom_libro'],
				$_REQUEST ['editorial'],
				$_REQUEST ['anioL'],
				$_REQUEST ['fechaTraducc'],
				$_REQUEST ['numeActa'],
				$_REQUEST ['fechaActa'],
				$_REQUEST ['numeCaso'],
				$_REQUEST ['puntaje'],
				$_REQUEST ['detalleDocencia'] 
		);
	} else {
		$arregloDatos = array (
				$_REQUEST ['identificacionFinalCrear'],
				$_REQUEST ['titulo_publicacion'],
				$_REQUEST ['titulo_traduccion'],
				$_REQUEST ['revista'],
				$_REQUEST ['tipo_traducc'],
				$_REQUEST ['num_revista'],
				$_REQUEST ['volumen'],
				$_REQUEST ['anioR'],
				$_REQUEST ['tipo_revista'],
				$_REQUEST ['nom_libro'] = "NULL",
				$_REQUEST ['editorial'] = "NULL",
				$_REQUEST ['anioL'] = "NULL",
				$_REQUEST ['fechaTraducc'],
				$_REQUEST ['numeActa'],
				$_REQUEST ['fechaActa'],
				$_REQUEST ['numeCaso'],
				$_REQUEST ['puntaje'],
				$_REQUEST ['detalleDocencia'] 
		);
	}
	
	{
		$docente = $_REQUEST ['docente'];
		
		$verificarTraduccion = array (
				$_REQUEST ['identificacionFinalCrear'],
				trim($_REQUEST ['titulo_traduccion']),
				substr ( $_REQUEST ['fechaTraducc'], 0, 4 ) 
		);
		
		
		
		$this->cadena_sql = $this->sql->cadena_sql ( "repTraducciones", $verificarTraduccion );
		$resultadoBusqueda = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "busqueda" );
		
		
		$puedeInsertar = 0;
		
		
		if ($resultadoBusqueda[0][0] == '1') {
			
 			$this->funcion->redireccionar ( 'repTraduccion', $docente );
		} else {
			
			$this->cadena_sql = $this->sql->cadena_sql ( "numTraducciones", $verificarTraduccion );
			$resultadoBusqueda = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "busqueda" );
			
			
			if ($resultadoBusqueda[0][0]== '5') {
				
				$this->funcion->redireccionar ( 'maxTraduccion', $docente );
				
			} else {
				
				$puedeInsertar = 1;
			}
		}
	}
	if ($puedeInsertar == 1) {
		$sql = $this->sql->cadena_sql ( "insertarTraduccion", $arregloDatos );
		$resultadoTraduccion = $esteRecursoDB->ejecutarAcceso ( $sql, "acceso" );
		
		$arregloLogEvento = array (
				'traduccion_docente',
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
		
		if ($resultadoTraduccion) {
			$this->funcion->redireccionar ( 'inserto', $docente );
		} else {
			$this->funcion->redireccionar ( 'noInserto', $docente );
		}
	}
}
?>