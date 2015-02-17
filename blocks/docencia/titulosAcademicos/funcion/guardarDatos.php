<?php

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	$miSesion = Sesion::singleton ();
	
        if(!is_numeric($_REQUEST ['identificacionFinalCrear']) || $_REQUEST ['identificacionFinalCrear'] == '')
            {                   
                $this->funcion->redireccionar ( 'noDatosDocente', '' );
            }else
                {
        
                    if (!is_numeric ( $_REQUEST ['puntaje'] )) {

                            $_REQUEST ['puntaje'] = 0;
                    }

                    $conexion = "estructura";
                    $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );

                    if ($_REQUEST ['resolucion'] == '') {
                            $resolucion = '';
                    } else {
                            $resolucion = $_REQUEST ['resolucion'];
                    }

                    if ($_REQUEST ['fechaResolucion'] == '') {
                            $fecharesolucion = '';
                    } else {
                            $fecharesolucion = $_REQUEST ['fechaResolucion'];
                    }

                    if ($_REQUEST ['entidadConvalida'] == '') {
                            $entidad = '';
                    } else {
                            $entidad = $_REQUEST ['entidadConvalida'];
                    }

                    $arregloTitu = array (
                                    $_REQUEST ['identificacionFinalCrear'],
                                    $_REQUEST ['tipo_titulo'] 
                    );

                    $this->cadena_sql = $this->sql->cadena_sql ( "buscarTitulosDocente", $arregloTitu );
                    $resultadoTotal = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "busqueda" );

                    if (is_array ( $resultadoTotal )) {
                            $consecutivo = count ( $resultadoTotal ) + 1;
                    } else {
                            $consecutivo = 1;
                    }

                    $arregloDatos = array (
                                    $_REQUEST ['identificacionFinalCrear'],
                                    $_REQUEST ['tipo_titulo'],
                                    $_REQUEST ['titulo_otorgado'],
                                    $_REQUEST ['universidad'],
                                    $_REQUEST ['fechaFin'],
                                    $_REQUEST ['modalidad'],
                                    $_REQUEST ['pais'],
                                    $resolucion,
                                    $fecharesolucion,
                                    $entidad,
                                    $_REQUEST ['numeActa'],
                                    $_REQUEST ['fechaActa'],
                                    $_REQUEST ['numeCaso'],
                                    $_REQUEST ['puntaje'],
                                    $_REQUEST ['detalleDocencia'],
                                    $consecutivo 
                    );

                    $this->cadena_sql = $this->sql->cadena_sql ( "insertarTitulo", $arregloDatos );
                    $resultadoTitulo = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );

                    $arregloLogEvento = array (
                                    'titulos_academicos',
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

                    if ($resultadoTitulo) {
                            $this->funcion->redireccionar ( 'inserto', $_REQUEST ['docente'] );
                    } else {
                            $this->funcion->redireccionar ( 'noInserto', $_REQUEST ['docente'] );
                    }
                }
}
?>