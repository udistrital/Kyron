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
			$_REQUEST ['idTecnSotf'],
			$_REQUEST ['tipo'],
			$_REQUEST ['numeCertificado'],
			$_REQUEST ['numEvaluadores'],
			$_REQUEST ['fechaPr'],
			$_REQUEST ['numeActa'],
			$_REQUEST ['fechaActa'],
			$_REQUEST ['numeCaso'],
			$_REQUEST ['puntaje'],
			$_REQUEST ['detalleDocencia'] 
	);
	
	switch ($_REQUEST ['numEvaluadores']) {
		
		case '2' :
			
			$_REQUEST ['idEvaluador1'];
                    
			$_REQUEST ['nomEvaluador1'];
                        
			$_REQUEST ['univEva1'];
			
			$_REQUEST ['puntEvaluador1'];
                        
                        $_REQUEST ['idEvaluador2'];
			
			$_REQUEST ['nomEvaluador2'];
                        
                        $_REQUEST ['univEva2'];
			
			$_REQUEST ['puntEvaluador2'];
                        
                        $_REQUEST ['idEvaluador3'] = '0';
			
			$_REQUEST ['nomEvaluador3'] = "NULL";
                        
			$_REQUEST ['univEva3'] = '0';
			
			$_REQUEST ['puntEvaluador3'] = '0';
			break;
		
		case '3' :
			
			$_REQUEST ['idEvaluador1'];
                    
			$_REQUEST ['nomEvaluador1'];
                        
			$_REQUEST ['univEva1'];
			
			$_REQUEST ['puntEvaluador1'];
                        
                        $_REQUEST ['idEvaluador2'];
			
			$_REQUEST ['nomEvaluador2'];
                        
                        $_REQUEST ['univEva2'];
			
			$_REQUEST ['puntEvaluador2'];
                        
                        $_REQUEST ['idEvaluador3'] ;
			
			$_REQUEST ['nomEvaluador3'];
                        
			$_REQUEST ['univEva3'];
			
			$_REQUEST ['puntEvaluador3'];
			
			break;
	}
	{
		$docente = $_REQUEST ['identificacion'];
		
		$verificar = array (
				$_REQUEST ['identificacion'],
				$_REQUEST ['fechaPr'] 
		); 
		
		$puedeInsertar = 0;
		
		$this->cadena_sql = $this->sql->cadena_sql ( "idActualizar", $_REQUEST['idTecnSotf'] );
		$resultadoAct = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "busqueda" );
                                
                if($resultadoAct[0][0] != $_REQUEST ['fechaPr'])
                    {   
                        $docente = $_REQUEST ['identificacion'];
			
			$verificar = array (
					$_REQUEST ['identificacion'],
					substr ( $_REQUEST ['fechaPr'], 0, 4 ),
					$_REQUEST ['idTecnSotf'] 
			);
			
			$this->cadena_sql = $this->sql->cadena_sql ( "numTecSoft", $verificar );
			$resultadoBusqueda = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "busqueda" );
			
			switch ($resultadoBusqueda [0] [0]) {
				
				case '2' :
					
					$this->funcion->redireccionar ( 'maxTecSof', $docente );
					$puedeInsertar = 0;
					break;
				
				default :
					// Se realiza la consulta
					
					$puedeInsertar = 1;
					
					break;
			}
                    }else
                    {
                        $puedeInsertar = 1;
                    }
	}
	

	if ($puedeInsertar == 1) {
		$cadena_sql = $this->sql->cadena_sql ( "actualizarTecSoft", $arregloDatos );
		
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
		
		$arregloLogEvento = array (
				'tecn_sotf_docente',
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
		
		$id_evaluadores = unserialize ( $_REQUEST ['idEvaluadores'] );
		
		for($i = 1; $i <= 3; $i ++) {
			$arregloEvaluadores = array (
					$_REQUEST ['idEvaluador' . $i],
					$_REQUEST ['nomEvaluador' . $i],
					$_REQUEST ['univEva' . $i],
					$_REQUEST ['puntEvaluador' . $i] 
			);
			
			$this->cadena_sql = $this->sql->cadena_sql ( "actualizarEvaluadores", $arregloEvaluadores, $id_evaluadores [$i] );
			$resultadoAutores = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
			
			$arregloLogEvento = array (
					'evaluador_tec_sotf',
					$arregloEvaluadores,
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
		}
		
		if ($resultado) {
			$this->funcion->redireccionar ( 'Actualizo', $_REQUEST ['identificacion'] );
		} else {
			$this->funcion->redireccionar ( 'noActualizo', $_REQUEST ['identificacion'] );
		}
        }else
            {
                $this->funcion->redireccionar ( 'noActualizo', $_REQUEST ['identificacion'] );
            }
}
?>