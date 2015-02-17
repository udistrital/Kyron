<?php

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	
	$miSesion = Sesion::singleton ();
	
	$conexion = "estructura";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	//var_dump($_REQUEST);exit;
	if ($_REQUEST ['contextoActual'] == '1') {
		
		$arregloDatos = array (
				
				$_REQUEST ['idPonencia'],
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
	} else if ($_REQUEST ['contextoActual'] != '1' ) {
		
		$arregloDatos = array (
				
				$_REQUEST ['idPonencia'],
				$_REQUEST ['titulo_ponencia'],
				$_REQUEST ['autoresPonencia'],
				$_REQUEST ['fechaPonencia'],
				$_REQUEST ['contexto'],
				$_REQUEST ['evento'],
				$_REQUEST ['ciudad'] = $_REQUEST ['ciudad1'],
				$_REQUEST ['pais'] = 'COL',
				$_REQUEST ['num_certificado'],
				$_REQUEST ['numeActa'],
				$_REQUEST ['fechaActa'],
				$_REQUEST ['numeCaso'],
				$_REQUEST ['puntaje'], 
                                $_REQUEST ['detalleDocencia'], 
                                $_REQUEST ['autoresUD'] 
		);
	}
	
	$id_ponencia = $_REQUEST ['idPonencia'];

	$this->cadena_sql = $this->sql->cadena_sql ( "docentePonencia", $id_ponencia );
	$resultadoDocente = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "busqueda" );

	$docente = $resultadoDocente[0][0];

	$verificarPonencia = array($docente,$_REQUEST['contexto'],substr($_REQUEST['fechaPonencia'],0,4));

        $puedeInsertar = 0;
        if($_REQUEST['contexto'] != $_REQUEST['contextoActual'] )
            {
                switch($verificarPonencia[1])
                {

                        case '3':

                                //Se realiza la consulta
                                $this->cadena_sql = $this->sql->cadena_sql ( "numPonenciasContexto", $verificarPonencia );
                                $resultadoBusqueda = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "busqueda" );

                                if($resultadoBusqueda[0][0] <= 1)
                                {
                                        $this->cadena_sql = $this->sql->cadena_sql ( "numPonencias", $verificarPonencia );
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
                                $this->cadena_sql = $this->sql->cadena_sql ( "numPonenciasContexto", $verificarPonencia );
                                $resultadoBusqueda = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "busqueda" );

                                if($resultadoBusqueda[0][0] <= 2)
                                {
                                        $this->cadena_sql = $this->sql->cadena_sql ( "numPonencias", $verificarPonencia );
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
            }else
                {
                    $puedeInsertar = 1;
                }

	if($puedeInsertar == 1)
	{

		$sql = $this->cadena_sql = $this->sql->cadena_sql ( "actualizarPonencia", $arregloDatos );
	
		$resultadoPonencia = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
	
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
	
		if ($resultadoPonencia) {
			$this->funcion->redireccionar ( 'Actualizo', $_REQUEST ['idPonencia'] );
		} else {
			$this->funcion->redireccionar ( 'noActualizo', $_REQUEST ['idPonencia'] );
		}
	}
}

?>
