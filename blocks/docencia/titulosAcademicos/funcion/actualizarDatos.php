<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	
	$miSesion = Sesion::singleton ();
	
	$conexion = "estructura";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
        
        if (!isset($_REQUEST ['puntaje']) || !is_numeric( $_REQUEST ['puntaje'] )) {
		
		$_REQUEST ['puntaje'] = 0;
	}
        
        if($_REQUEST['resolucion'] == '')
            {
                $resolucion = '';
            }else
                {
                    $resolucion = $_REQUEST['resolucion'];
                }
        
        if($_REQUEST['fechaResolucion'] == '')
            {
                $fecharesolucion = '';
            }else
                {
                    $fecharesolucion = $_REQUEST['fechaResolucion'];
                }
        
        if($_REQUEST['entidadConvalida'] == '')
            {
                $entidad = '';
            }else
                {
                    $entidad = $_REQUEST['entidadConvalida'];
                }
                
        $arregloDatos = array($_REQUEST['id_docente'],
                              $_REQUEST['tipo_titulo'],
                              $_REQUEST['titulo_otorgado'],
                              $_REQUEST['universidad'],
                              $_REQUEST['fechaFin'],
                              $_REQUEST['modalidad'],  
                              $_REQUEST['pais'],                              
                              $resolucion,
                              $fecharesolucion,
                              $entidad,
                              $_REQUEST['numeActa'],
                              $_REQUEST['fechaActa'],
                              $_REQUEST['numeCaso'],
                              $_REQUEST['puntaje'],
                              $_REQUEST['detalleDocencia'],
                              $_REQUEST['cons_titu'],
                              $_REQUEST['id_titulo']);            
        
        
	$sql = $this->cadena_sql = $this->sql->cadena_sql ( "actualizarTitulo", $arregloDatos );	
	$resultadoTitulos = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
	
	$arregloLogEvento = array (
			'titulos_academicos',
			$arregloDatos,
			$miSesion->getSesionUsuarioId(),
			$_SERVER ['REMOTE_ADDR'],
			$_SERVER ['HTTP_USER_AGENT']
	);
	
	$argumento = json_encode ( $arregloLogEvento );
	$arregloFinalLogEvento = array($miSesion->getSesionUsuarioId(), $argumento);
	
	$cadena_sql = $this->sql->cadena_sql ( "registrarEvento", $arregloFinalLogEvento );
	$registroAcceso = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
	
	if ($resultadoTitulos) {
    
            $this->funcion->redireccionar ( 'Actualizo', $_REQUEST ['id_docente'] );    
                
	} else {
		$this->funcion->redireccionar ( 'noActualizo', $_REQUEST ['id_docente'] );
	}
}

?>