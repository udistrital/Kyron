<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	
	$miSesion = Sesion::singleton ();
	
	$conexion = "estructura";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
        
        $arregloVideo = array(                                
				$_REQUEST ['idvideo'],
				$_REQUEST ['titulo_video'],
				$_REQUEST ['numAuto'],
				$_REQUEST ['numAutoUD'],
				$_REQUEST ['fechaVideo'],
				$_REQUEST ['impacto'],
				$_REQUEST ['caracter'],
				$_REQUEST ['numeActa'],
				$_REQUEST ['fechaActa'],
				$_REQUEST ['numeCaso'],
				$_REQUEST ['puntaje'],
				$_REQUEST ['detalleDocencia']
        );

	$sql = $this->cadena_sql = $this->sql->cadena_sql ( "actualizarVideos", $arregloVideo );	
	$resultadoVideos = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
	
	$arregloLogEvento = array (
			'prvideos_docente',
			$arregloVideo,
			$miSesion->getSesionUsuarioId(),
			$_SERVER ['REMOTE_ADDR'],
			$_SERVER ['HTTP_USER_AGENT']
	);
	
	$argumento = json_encode ( $arregloLogEvento );
	$arregloFinalLogEvento = array($miSesion->getSesionUsuarioId(), $argumento);
	
	$cadena_sql = $this->sql->cadena_sql ( "registrarEvento", $arregloFinalLogEvento );
	$registroAcceso = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
	
	if ($resultadoVideos) {
                
                for($i=1;$i<=3;$i++)
                {
                    if(isset($_REQUEST['id_revisor'.$i]) && trim($_REQUEST['nomEvaluador'.$i]) != '' )
                    {
                        $arregloEvaluadores = array(                                
				$_REQUEST ['idvideo'],
				$_REQUEST ['id_revisor'.$i],
				$_REQUEST ['nomEvaluador'.$i],
				$_REQUEST ['uniEvaluador'.$i],
				$_REQUEST ['puntEvaluador'.$i]
                        );
                        
                        $sql = $this->cadena_sql = $this->sql->cadena_sql ( "actualizarEvaluador", $arregloEvaluadores );	
                        $resultadoEvaluadores = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
                        
                        $arregloLogEvento = array (
                            'revisores_videos',
                            $arregloEvaluadores,
                            $miSesion->getSesionUsuarioId(),
                            $_SERVER ['REMOTE_ADDR'],
                            $_SERVER ['HTTP_USER_AGENT']
                        );

                        $argumento = json_encode ( $arregloLogEvento );
                        $arregloFinalLogEvento = array($miSesion->getSesionUsuarioId(), $argumento);

                        $cadena_sql = $this->sql->cadena_sql ( "registrarEvento", $arregloFinalLogEvento );
                        $registroAcceso = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
                        
                    }else if(isset($_REQUEST['id_revisor'.$i]) && trim($_REQUEST['nomEvaluador'.$i]) === '' )
                        {
                            $arregloEvaluadores = array(                                
				$_REQUEST ['idvideo'],
				$_REQUEST ['id_revisor'.$i],
				$_REQUEST ['nomEvaluador'.$i],
				$_REQUEST ['uniEvaluador'.$i],
				$_REQUEST ['puntEvaluador'.$i]
                            );

                            $sql = $this->cadena_sql = $this->sql->cadena_sql ( "inhabilitarEvaluador", $arregloEvaluadores );	
                            $resultadoEvaluadores = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );

                            $arregloLogEvento = array (
                                'revisores_videos',
                                $arregloAutores,
                                $miSesion->getSesionUsuarioId(),
                                $_SERVER ['REMOTE_ADDR'],
                                $_SERVER ['HTTP_USER_AGENT']
                            );

                            $argumento = json_encode ( $arregloLogEvento );
                            $arregloFinalLogEvento = array($miSesion->getSesionUsuarioId(), $argumento);

                            $cadena_sql = $this->sql->cadena_sql ( "registrarEvento", $arregloFinalLogEvento );
                            $registroAcceso = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
                        }else if(isset($_REQUEST['nomEvaluador'.$i]) && trim($_REQUEST['nomEvaluador'.$i]) != '' )
                            {
                                $arregloEvaluadores = array(                                
                                    $_REQUEST ['idvideo'],
                                    $_REQUEST ['nomEvaluador'.$i],
                                    $_REQUEST ['uniEvaluador'.$i],
                                    $_REQUEST ['puntEvaluador'.$i]
                                );

                                $sql = $this->cadena_sql = $this->sql->cadena_sql ( "insertarNuevoEvaluador", $arregloEvaluadores );	
                                $resultadoEvaluadores = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );

                                $arregloLogEvento = array (
                                    'revisores_videos',
                                    $arregloAutores,
                                    $miSesion->getSesionUsuarioId(),
                                    $_SERVER ['REMOTE_ADDR'],
                                    $_SERVER ['HTTP_USER_AGENT']
                                );

                                $argumento = json_encode ( $arregloLogEvento );
                                $arregloFinalLogEvento = array($miSesion->getSesionUsuarioId(), $argumento);

                                $cadena_sql = $this->sql->cadena_sql ( "registrarEvento", $arregloFinalLogEvento );
                                $registroAcceso = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
                            }
                }
                                
            $this->funcion->redireccionar ( 'Actualizo', $_REQUEST ['docente'] );    
                
	} else {
		$this->funcion->redireccionar ( 'noActualizo', $_REQUEST ['docente'] );
	}
}

?>