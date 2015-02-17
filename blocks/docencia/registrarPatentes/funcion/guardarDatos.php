<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	
	$miSesion = Sesion::singleton ();
	
	$conexion = "estructura";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	
        if(!is_numeric($_REQUEST ['identificacionFinalCrear']) || $_REQUEST ['identificacionFinalCrear'] == '')
            {                   
                $this->funcion->redireccionar ( 'noDatosDocente', '' );
            }else
                {
                    $arregloDatos = array (
                                    $_REQUEST ['identificacionFinalCrear'],
                                    $_REQUEST ['tipoPatente'],
                                    $_REQUEST ['tituloPatente'],
                                    $_REQUEST ['entidadPatente'],
                                    $_REQUEST ['paisPatente'],
                                    $_REQUEST ['añoPatente'],
                                    $_REQUEST ['conceptoPatente'],
                                    $_REQUEST ['numeroRegistro'],
                                    $_REQUEST ['numeroActa'],
                                    $_REQUEST ['fechaActa'],
                                    $_REQUEST ['numeroCaso'],
                                    $_REQUEST ['puntaje'], 
                                    $_REQUEST ['detalleDocencia'] 
                    );

                    $this->cadena_sql = $this->sql->cadena_sql ( "insertarPatente", $arregloDatos );
                    $resultadoPatentes = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );

                    $arregloLogEvento = array (
                                    'registrar_patentes',
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

                    if ($resultadoPatentes) {
                            $this->funcion->redireccionar ( 'inserto', $_REQUEST ['docente'] );
                    } else {
                            $this->funcion->redireccionar ( 'noInserto', $_REQUEST ['docente'] );
                    }
                }
}
?>