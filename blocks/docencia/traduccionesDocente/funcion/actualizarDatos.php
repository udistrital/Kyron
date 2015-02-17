<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	
	$miSesion = Sesion::singleton ();
	
	$conexion = "estructura";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );

        if ($_REQUEST ['tipo_traducc'] == '1') {
		
		$arregloDatos = array (
				$_REQUEST ['idTraduccion'],
				$_REQUEST ['titulo_publicacion'],
				$_REQUEST ['titulo_traduccion'],
				$_REQUEST ['revista'] = "NULL",
				$_REQUEST ['tipo_traducc'],
				$_REQUEST ['num_revista'] = "NULL",
				$_REQUEST ['volumen'] = "NULL",
				$_REQUEST ['anioR'] = "NULL",
				$_REQUEST ['tipo_revista'] = "NULL",
				$_REQUEST ['nom_libro'],
				$_REQUEST ['editorial'],
				$_REQUEST ['anioL'],
				$_REQUEST ['fechaTraducc'],
				$_REQUEST ['numeActa'],
				$_REQUEST ['fechaActa'],
				$_REQUEST ['numeCaso'],
				$_REQUEST ['puntaje'],
				$_REQUEST ['detalleDocencia'] 
		);
	} else {
		$arregloDatos = array (
				$_REQUEST ['idTraduccion'],
				$_REQUEST ['titulo_publicacion'],
				$_REQUEST ['titulo_traduccion'],
				$_REQUEST ['revista'],
				$_REQUEST ['tipo_traducc'],
				$_REQUEST ['num_revista'],
				$_REQUEST ['volumen'],
				$_REQUEST ['anioR'],
				$_REQUEST ['tipo_revista'],
				$_REQUEST ['nom_libro'] = "NULL",
				$_REQUEST ['editorial'] = "NULL",
				$_REQUEST ['anioL'] = "NULL",
				$_REQUEST ['fechaTraducc'],
				$_REQUEST ['numeActa'],
				$_REQUEST ['fechaActa'],
				$_REQUEST ['numeCaso'],
				$_REQUEST ['puntaje'],
				$_REQUEST ['detalleDocencia'] 
		);
	}
	
        $fechaAnterior = substr ( $_REQUEST ['fechaTraduccAnterior'], 0, 4 );
        $fechaNueva = substr ( $_REQUEST ['fechaTraducc'], 0, 4 );
        
        $puedeInsertar = 1;
        
        $docente = $_REQUEST ['identificacion'];
		
		$verificarTraduccion = array (
				$_REQUEST ['identificacion'],
				trim ( $_REQUEST ['titulo_traduccion'] ),
				substr ( $_REQUEST ['fechaTraducc'], 0, 4 ) 
		);
		$valor_id = $_REQUEST ['idTraduccion'];
		$id_traduccion = $_REQUEST ['idTraduccion'];
        
        if($fechaAnterior != $fechaNueva) 
        {
            $this->cadena_sql = $this->sql->cadena_sql ( "numTraducciones", $verificarTraduccion );
            $resultadoBusquedaNumero = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "busqueda" );
            
            if ($resultadoBusquedaNumero [0] [0] >= 5) 
            {
                $puedeInsertar = 0;
                $error = "maxTraduccion";
            }else 
                {			
                    $puedeInsertar = 1;
		}
        } 
        
        if($_REQUEST['titulo_traduccion'] != $_REQUEST['titulo_traduccionAnterior'])
            {
		// Verifica si se repiten las traducciones
		$this->cadena_sql = $this->sql->cadena_sql ( "repTraducciones", $verificarTraduccion );
		$resultadoBusqueda = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "busqueda" );
		
		$sql = $this->sql->cadena_sql ( "repModificarTraducciones", $verificarTraduccion );
		$resultadoBusquedaID = $esteRecursoDB->ejecutarAcceso ( $sql, "busqueda" );
		
		if ($resultadoBusqueda [0] [0] == '1' && $resultadoBusquedaID [0] [0] != $valor_id) 
                    {
			$puedeInsertar = 0;
			$error = "repTraduccion";
                    } else if ($resultadoBusqueda [0] [0] == '0' && $resultadoBusquedaID [0] [0] == '') 
                        {
                            $puedeInsertar = 1;
                        }else {
                            $puedeInsertar = 1;
                        }
            }
        
	if ($puedeInsertar == 1) {
		// var_dump($arregloDatos);
		
		$this->cadena_sql = $this->sql->cadena_sql ( "actualizarTraduccion", $arregloDatos );
		// var_dump($this->cadena_sql);
		$resultadoTraduccion = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
		// var_dump($_REQUEST);exit;
		
		$arregloLogEvento = array (
				'traduccion_docente',
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
		
		if ($resultadoTraduccion) {
			$this->funcion->redireccionar ( 'Actualizo', $id_traduccion );
		} else {
			$this->funcion->redireccionar ( 'noActualizo', $id_traduccion );
		}
        }else
            {
                $this->funcion->redireccionar ( $error, $docente );
            }
}

?>