<?php
//var_dump($_REQUEST);exit;
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	if(!is_numeric($_REQUEST ['identificacionFinalCrear']) || $_REQUEST ['identificacionFinalCrear'] == '')
            {                   
                $this->funcion->redireccionar ( 'noDatosDocente', '' );
            }else
                {
                    $miSesion = Sesion::singleton ();

                    $conexion = "estructura";
                    $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ($conexion );

                    $conexionEstructura = "estructura";
                    $esteRecursoDBEstructura = $this->miConfigurador->fabricaConexiones->getRecursoDB ($conexionEstructura );

                    $arregloDatos = array (
                                    $_REQUEST ['identificacionFinalCrear'],
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

                    $this->cadena_sql = $this->sql->cadena_sql ( "insertarvideo", $arregloDatos );
                    $resultado= $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "busqueda" );

                    $arregloLogEvento = array (
                                    'prvideos_docente',
                                    $arregloDatos,
                                    $miSesion->getSesionUsuarioId(),
                                    $_SERVER ['REMOTE_ADDR'],
                                    $_SERVER ['HTTP_USER_AGENT'] 
                    );

                    $argumento = json_encode ( $arregloLogEvento );
                    $arregloFinalLogEvento = array($miSesion->getSesionUsuarioId(), $argumento);

                    $cadena_sql = $this->sql->cadena_sql ( "registrarEvento", $arregloFinalLogEvento );
                    $registroAcceso = $esteRecursoDBEstructura->ejecutarAcceso ( $cadena_sql, "acceso" );

                    if($resultado)
                        {                                
                            for($j=1; $j<=$_REQUEST['numEvaluadores']; $j++)
                            {
                                $arregloEvaluadores = array($_REQUEST['nomEvaluador'.$j],$_REQUEST['uniEvaluador'.$j],$_REQUEST['puntEvaluador'.$j]);
                                $this->cadena_sql = $this->sql->cadena_sql ( "insertEva", $arregloEvaluadores, $resultado[0][0] );
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
                                $registroAcceso = $esteRecursoDBEstructura->ejecutarAcceso ( $cadena_sql, "acceso" );
                            }
                        }

                    if ($resultado) {
                            $this->funcion->redireccionar ( 'inserto', $_REQUEST ['docente'] );
                    } else {
                            $this->funcion->redireccionar ( 'noInserto', $_REQUEST ['docente'] );
                    }
                }
}
?>