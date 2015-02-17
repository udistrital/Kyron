<?php
//var_dump ( $_REQUEST );exit;
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	
	$miSesion = Sesion::singleton ();
	
	$conexion = "estructura";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
	if ( $_REQUEST ['pais']  && $_REQUEST ['pais'] != '-1') {
		
		$arregloDatos = array (
				
				$_REQUEST ['identificacionFinalCrear'],
				$_REQUEST ['titulo_ponencia'],
				$_REQUEST ['autoresPonencia'],
				$_REQUEST ['fechaPonencia'],
				$_REQUEST ['contexto'],
				$_REQUEST ['evento'],
				$_REQUEST ['ciudad'],
				$_REQUEST ['pais'],
				$_REQUEST ['num_certificado'],
				$_REQUEST ['numeActa'],
				$_REQUEST ['fechaActa'],
				$_REQUEST ['numeCaso'],
				$_REQUEST ['puntaje'],
                                $_REQUEST ['detalleDocencia'],
                                $_REQUEST ['autoresUD']
		);
	} else if ($_REQUEST ['pais']==''|| $_REQUEST ['pais'] == '-1') {
		
		$arregloDatos = array (
				
				$_REQUEST ['identificacionFinalCrear'],
				$_REQUEST ['titulo_ponencia'],
				$_REQUEST ['autoresPonencia'],
				$_REQUEST ['fechaPonencia'],
				$_REQUEST ['contexto'],
				$_REQUEST ['evento'],
				$_REQUEST ['ciudad']=$_REQUEST ['ciudad1'],
				$_REQUEST ['pais']='COL',
				$_REQUEST ['num_certificado'],
				$_REQUEST ['numeActa'],
				$_REQUEST ['fechaActa'],
				$_REQUEST ['numeCaso'],
				$_REQUEST ['puntaje'],
                                $_REQUEST ['detalleDocencia'],
                                $_REQUEST ['autoresUD'] 
		);
	}
	$docente = $_REQUEST ['docente'];
	

	$verificarPonenecia = array($_REQUEST ['identificacionFinalCrear'],$_REQUEST ['contexto'],substr($_REQUEST ['fechaPonencia'],0,4));

	$puedeInsertar = 0;

	switch($verificarPonenecia[1])
	{

		case '3':

			//Se realiza la consulta
			$this->cadena_sql = $this->sql->cadena_sql ( "numPonenciasContexto", $verificarPonenecia );
			$resultadoBusqueda = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "busqueda" );

			if($resultadoBusqueda[0][0] <= 1)
			{
				$this->cadena_sql = $this->sql->cadena_sql ( "numPonencias", $verificarPonenecia );
				$resultadoTotal = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "busqueda" );

				if($resultadoTotal[0][0]<=4)
				{
					$puedeInsertar = 1;				
				}else{
					$this->funcion->redireccionar ( 'maxPonencias', $docente );
					}

			}else
				{
					$this->funcion->redireccionar ( 'maxPonenciasInternal', $docente );
				}
			
						
		break;

		default:
			//Se realiza la consulta
			$this->cadena_sql = $this->sql->cadena_sql ( "numPonenciasContexto", $verificarPonenecia );
			$resultadoBusqueda = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "busqueda" );

			if($resultadoBusqueda[0][0] <= 2)
			{
				$this->cadena_sql = $this->sql->cadena_sql ( "numPonencias", $verificarPonenecia );
				$resultadoTotal = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "busqueda" );

				if($resultadoTotal[0][0]<=4)
				{
					$puedeInsertar = 1;				
				}else{
					$this->funcion->redireccionar ( 'maxPonencias', $docente );
					}

			}else
				{
					$this->funcion->redireccionar ( 'maxPonenciasNal', $docente );
				}
		break;

	}

	if($puedeInsertar == 1)
	{
	
		$sql = $this->cadena_sql = $this->sql->cadena_sql ( "insertarPonencia", $arregloDatos );
	
		$resultadoExperiencia = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
	
		$arregloLogEvento = array (
				'ponencia_docente',
				$arregloDatos,
				$miSesion->getSesionUsuarioId(),
				$_SERVER ['REMOTE_ADDR'],
				$_SERVER ['HTTP_USER_AGENT']
		);
	
		$argumento = json_encode ( $arregloLogEvento );
		$arregloFinalLogEvento = array($miSesion->getSesionUsuarioId(), $argumento);
	
		$cadena_sql = $this->sql->cadena_sql ( "registrarEvento", $arregloFinalLogEvento );
		$registroAcceso = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
	
		if ($resultadoExperiencia) {
		
			$this->funcion->redireccionar ( 'Inserto', $docente );
		} else {
			$this->funcion->redireccionar ( 'noInserto', $docente );
		}
	}	
}

?>
