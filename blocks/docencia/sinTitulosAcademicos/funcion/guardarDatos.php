<?php

if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{
	if(!is_numeric($_REQUEST ['identificacionFinalCrear']) || $_REQUEST ['identificacionFinalCrear'] == '')
            {                   
                $this->funcion->redireccionar ( 'noDatosDocente', '' );
            }else
                { 
                    $miSesion = Sesion::singleton();

                    $conexion="estructura";
                    $esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

                    $arregloDatos = array($_REQUEST['identificacionFinalCrear'],
                                          $_REQUEST['numeActa'],
                                          $_REQUEST['fechaActa'],
                                          $_REQUEST['numeCaso'],
                                          $_REQUEST['categoria'],
                                          $_REQUEST['puntaje'],
                                          $_REQUEST['detalleDocencia']);

                    $this->cadena_sql = $this->sql->cadena_sql("insertarSinTitulo", $arregloDatos); 
                    $resultadoTitulo = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "acceso");

                    $arregloLogEvento = array (
                                    'sintitulos_academicos',
                                    $arregloDatos,
                                    $miSesion->getSesionUsuarioId(),
                                    $_SERVER ['REMOTE_ADDR'],
                                    $_SERVER ['HTTP_USER_AGENT']
                    );

                    $argumento = json_encode ( $arregloLogEvento );
                    $arregloFinalLogEvento = array($miSesion->getSesionUsuarioId(), $argumento);

                    $cadena_sql = $this->sql->cadena_sql ( "registrarEvento", $arregloFinalLogEvento );
                    $registroAcceso = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );

                    if($resultadoTitulo)
                    {	
                            $this->funcion->redireccionar('inserto',$_REQUEST['docente']);
                    }else
                    {
                            $this->funcion->redireccionar('noInserto',$_REQUEST['docente']);
                    }

                }

}
?>