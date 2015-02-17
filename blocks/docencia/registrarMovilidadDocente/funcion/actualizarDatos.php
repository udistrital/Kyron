<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
        $esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
	
	$rutaBloque=$this->miConfigurador->getVariableConfiguracion ( "rutaBloque" );
                
        $rutaBloqueUrl = $this->miConfigurador->getVariableConfiguracion ( "host" );
        $rutaBloqueUrl .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/";
        $rutaBloqueUrl .= $esteBloque ['grupo'] . "/" . $esteBloque ['nombre'];

        if ($_FILES ) {
		// obtenemos los datos del archivo
		$tamano = $_FILES["ponenciaPresentar"]['size'];
		$tipo = $_FILES["ponenciaPresentar"]['type'];
		$archivo1 = $_FILES["ponenciaPresentar"]['name'];
		$prefijo = substr(md5(uniqid(rand())),0,6);
		 
		if ($archivo1 != "") {
			// guardamos el archivo a la carpeta files
			$destino1 =  $rutaBloque."/archivoPonencia/".$prefijo."_".$archivo1;
			if (copy($_FILES['ponenciaPresentar']['tmp_name'],$destino1)) {
				$status = "Archivo subido: <b>".$archivo1."</b>";
				$destino1 =  $rutaBloque."/archivoPonencia/".$prefijo."_".$archivo1;
				$destino1Url =  $rutaBloqueUrl."/archivoPonencia/".$prefijo."_".$archivo1;

			} else {
				$destino1 = "";
			}
		} else {
			$destino1 = "";
		}
	}
	

	// obtenemos los datos del archivo
	$tamano = $_FILES["documentoAceptacion"]['size'];
	$tipo = $_FILES["documentoAceptacion"]['type'];
	$archivo2 = $_FILES["documentoAceptacion"]['name'];
	$prefijo = substr(md5(uniqid(rand())),0,6);
		
	if ($archivo2 != "") {
		// guardamos el archivo a la carpeta files
		$destino2 =  $rutaBloque."/archivoAceptacion/".$prefijo."_".$archivo2;
		if (copy($_FILES['documentoAceptacion']['tmp_name'],$destino2)) {
			$status = "Archivo subido: <b>".$archivo2."</b>";
			$destino2 =  $rutaBloque."/archivoAceptacion/".$prefijo."_".$archivo2;
			$destino2Url =  $rutaBloqueUrl."/archivoAceptacion/".$prefijo."_".$archivo2;
	
		} else {
			$destino2 = "";
		}
	} else {
		$destino2 = "";
	}

        if(isset($_REQUEST ['tiquetesDep']) && ($_REQUEST ['tiquetesDep']!='' && $_REQUEST ['tiquetesDep'] != '-1'))
            {
                $tiquetesDep = $_REQUEST ['tiquetesDep'];
                $tiquetesEnt = 'NULL';
            }else if(isset($_REQUEST ['tiquetesEnt']) && ($_REQUEST ['tiquetesEnt']!='' && $_REQUEST ['tiquetesEnt'] != '-1'))
                {
                    $tiquetesEnt = $_REQUEST ['tiquetesEnt'];
                    $tiquetesDep = 'NULL';
                }
	
        if(isset($_REQUEST ['viaticosDep']) && ($_REQUEST ['viaticosDep']!='' && $_REQUEST ['viaticosDep'] != '-1'))
            {
                $viaticosDep = $_REQUEST ['viaticosDep'];
                $viaticosEnt = 'NULL';
            }else if(isset($_REQUEST ['viaticosEnt']) && ($_REQUEST ['viaticosEnt']!='' && $_REQUEST ['viaticosEnt'] != '-1'))
                {
                    $viaticosEnt = $_REQUEST ['viaticosEnt'];
                    $viaticosDep = 'NULL';
                }
	
        if(isset($_REQUEST ['inscripcionDep']) && ($_REQUEST ['inscripcionDep']!='' && $_REQUEST ['inscripcionDep'] != '-1'))
            {
                $inscripcionDep = $_REQUEST ['inscripcionDep'];
                $inscripcionEnt = 'NULL';
            }else if(isset($_REQUEST ['inscripcionEnt']) && ($_REQUEST ['inscripcionEnt']!='' && $_REQUEST ['inscripcionEnt'] != '-1'))
                {
                    $inscripcionEnt = $_REQUEST ['inscripcionEnt'];
                    $inscripcionDep = 'NULL';
                }
	
	
	$miSesion = Sesion::singleton ();
	
	$conexion = "docencia";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	
	$arregloDatos = array (
			$_REQUEST ['id_movilidad'],
			$_REQUEST ['id_docente'],
			$tiquetesDep,
			$inscripcionDep,
			$viaticosDep,
			$tiquetesEnt,
			$inscripcionEnt,
			$viaticosEnt,
                        $destino1Url,
			$archivo1,
			$destino2Url,
			$archivo2 
	);
	 
	$this->cadena_sql = $this->sql->cadena_sql ( "actualizarMovilidad", $arregloDatos );
	$resultadoExperiencia = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
	
        $arregloLogEvento = array (
                        'movilidad_docente',
                        $arregloDatos,
                        $miSesion->getSesionUsuarioId(),
                        $_SERVER ['REMOTE_ADDR'],
                        $_SERVER ['HTTP_USER_AGENT'] 
        );

        $argumento = json_encode ( $arregloLogEvento );
        $arregloFinalLogEvento = array($miSesion->getSesionUsuarioId(), $argumento);
        
        $cadena_sql = $this->sql->cadena_sql ( "registrarEvento", $arregloFinalLogEvento );
        $registroAcceso = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );        
        
	if ($resultadoExperiencia) {
            
		$this->funcion->redireccionar ( 'actualizo', $_REQUEST ['id_docente'] );
                
	} else {
            
		$this->funcion->redireccionar ( 'noActualizo', $_REQUEST ['id_docente'] );
                
	}
}
?>