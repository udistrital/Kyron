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
        
        $arregloLibro = array(                                
				$_REQUEST ['id_libro'],
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
				$_REQUEST ['puntaje']
        );

	$sql = $this->cadena_sql = $this->sql->cadena_sql ( "actualizarLibros", $arregloLibro );	
	$resultadoLibros = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
	
	$arregloLogEvento = array (
			'registro_libros',
			$arregloLibro,
			$miSesion->getSesionUsuarioId(),
			$_SERVER ['REMOTE_ADDR'],
			$_SERVER ['HTTP_USER_AGENT']
	);
	
	$argumento = json_encode ( $arregloLogEvento );
	$arregloFinalLogEvento = array($miSesion->getSesionUsuarioId(), $argumento);
	
	$cadena_sql = $this->sql->cadena_sql ( "registrarEvento", $arregloFinalLogEvento );
	$registroAcceso = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
	
	if ($resultadoLibros) {
                
                for($i=1;$i<=3;$i++)
                {
                    if(isset($_REQUEST['id_revisor'.$i]) && trim($_REQUEST['idenEvaluador'.$i]) != '' && trim($_REQUEST['nomEvaluador'.$i]) != '' )
                    {
                        $arregloEvaluadores = array(                                
				$_REQUEST ['id_libro'],
				$_REQUEST ['id_revisor'.$i],
				$_REQUEST ['idenEvaluador'.$i],
				$_REQUEST ['nomEvaluador'.$i],
				$_REQUEST ['uniEvaluador'.$i],
				$_REQUEST ['puntEvaluador'.$i]
                        );
                        
                        $sql = $this->cadena_sql = $this->sql->cadena_sql ( "actualizarEvaluador", $arregloEvaluadores );	
                        $resultadoEvaluadores = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
                        
                        $arregloLogEvento = array (
                            'revisores_libros',
                            $arregloEvaluadores,
                            $miSesion->getSesionUsuarioId(),
                            $_SERVER ['REMOTE_ADDR'],
                            $_SERVER ['HTTP_USER_AGENT']
                        );

                        $argumento = json_encode ( $arregloLogEvento );
                        $arregloFinalLogEvento = array($miSesion->getSesionUsuarioId(), $argumento);

                        $cadena_sql = $this->sql->cadena_sql ( "registrarEvento", $arregloFinalLogEvento );
                        $registroAcceso = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
                        
                    }else if(isset($_REQUEST['id_revisor'.$i]) && trim($_REQUEST['idenEvaluador'.$i]) === '' && trim($_REQUEST['nomEvaluador'.$i]) === '')
                        {
                            $arregloEvaluadores = array(                                
				$_REQUEST ['id_libro'],
				$_REQUEST ['id_revisor'.$i],
				$_REQUEST ['idenEvaluador'.$i],
				$_REQUEST ['nomEvaluador'.$i],
				$_REQUEST ['uniEvaluador'.$i],
				$_REQUEST ['puntEvaluador'.$i]
                            );

                            $sql = $this->cadena_sql = $this->sql->cadena_sql ( "inhabilitarEvaluador", $arregloEvaluadores );	
                            $resultadoEvaluadores = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );

                            $arregloLogEvento = array (
                                'revisores_libros',
                                $arregloEvaluadores,
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
                                    $_REQUEST ['id_libro'],
                                    $_REQUEST ['id_revisor'.$i],
                                    $_REQUEST ['idenEvaluador'.$i],
                                    $_REQUEST ['nomEvaluador'.$i],
                                    $_REQUEST ['uniEvaluador'.$i],
                                    $_REQUEST ['puntEvaluador'.$i]
                                );

                                $sql = $this->cadena_sql = $this->sql->cadena_sql ( "insertarNuevoEvaluador", $arregloEvaluadores );	
                                $resultadoEvaluadores = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );

                                $arregloLogEvento = array (
                                    'revisores_libros',
                                    $arregloEvaluadores,
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
                
                
            $this->funcion->redireccionar ( 'Actualizo', $_REQUEST ['identificacion'] );    
                
	} else {
		$this->funcion->redireccionar ( 'noActualizo', $_REQUEST ['identificacion'] );
	}
}

?>