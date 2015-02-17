<?php

// var_dump($_REQUEST);exit;
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	
	$miSesion = Sesion::singleton ();
	
	$conexion = "estructura";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	
	$arregloDatos = array (
			$_REQUEST ['identificacionFinalCrear'],
			$_REQUEST ['tipo_obra_artistica'],
			$_REQUEST ['titulo_obra'],
			$_REQUEST ['certificada'],
			$_REQUEST ['anio_obra'],
			$_REQUEST ['contexto'],
			$_REQUEST ['numeActa'],
			$_REQUEST ['fechaActa'],
			$_REQUEST ['numeCaso'],
			$_REQUEST ['puntaje'],
                        $_REQUEST ['detalleDocencia']
	);
        
        $arregloValidar = array (
			$_REQUEST ['identificacionFinalCrear'],			
			$_REQUEST ['anio_obra']
	);
	
        $sql = $this->sql->cadena_sql ( "validarCantidad", $arregloValidar );
	$resultadoCantidad = $esteRecursoDB->ejecutarAcceso ( $sql, "busqueda" );
        
        if($resultadoCantidad[0][0] < 5)
            {
                $sql = $this->sql->cadena_sql ( "insertarObra", $arregloDatos );
                $resultadoExperiencia = $esteRecursoDB->ejecutarAcceso ( $sql, "acceso" );

                $arregloLogEvento = array (
                                'obras_docente',
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
            }else
                {
                    $this->funcion->redireccionar ( 'maxObras', $_REQUEST ['docente'] );
                }
        
	
	
	if ($resultadoExperiencia) {
		$this->funcion->redireccionar ( 'inserto', $_REQUEST ['docente'] );
	} else {
		$this->funcion->redireccionar ( 'noInserto', $_REQUEST ['docente'] );
	}
}
?>