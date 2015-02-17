<?php

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	
	$miSesion = Sesion::singleton ();
	
	$conexion = "estructura";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
	
        
        if($_REQUEST ['num_autores_cap'] == ''){
            $_REQUEST ['num_autores_cap'] = 0;
        }
        if($_REQUEST ['num_autores_universidad'] == ''){
            $_REQUEST ['num_autores_universidad'] = 0;
        }
        if($_REQUEST ['num_autores_libro'] == ''){
            $_REQUEST ['num_autores_libro'] = 0;
        }
        if($_REQUEST ['num_autores_libro_universidad'] == ''){
            $_REQUEST ['num_autores_libro_universidad'] = 0;
        }
        
	$arregloDatos = array (
			$_REQUEST ['idCapitulo'],
			$_REQUEST ['titulocapitulo'],
			$_REQUEST ['titulolibro'],
			$_REQUEST ['tipo_libro'],
			$_REQUEST ['codigo_numeracion'],
			$_REQUEST ['editorial'],
			$_REQUEST ['anio_libro'],
			$_REQUEST ['volumen'],
			$_REQUEST ['num_autores_cap'],
			$_REQUEST ['num_autores_universidad'],
			$_REQUEST ['num_autores_libro'],
			$_REQUEST ['num_autores_libro_universidad'],
			$_REQUEST ['numEvaluadores'],
			$_REQUEST ['numeActa'],
			$_REQUEST ['fechaActa'],
			$_REQUEST ['numeCaso'],
			$_REQUEST ['puntaje'], 
			$_REQUEST ['detalleDocencia'] 
	);
	
	

	
	$cadena_sql = $this->sql->cadena_sql ( "actualizarCapitulo", $arregloDatos );
	
	$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );
	
	$arregloLogEvento = array (
			'capitulo_libros',
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
	
	switch ($_REQUEST ['numEvaluadores']) {
		
		case '1' :
			
			$_REQUEST ['nomEvaluador1'];
			$_REQUEST ['uniEvaluador1'];
			$_REQUEST ['puntEvaluador1'];
			
			$_REQUEST ['nomEvaluador2'] = "NULL";
			$_REQUEST ['uniEvaluador2'] = '0';
			$_REQUEST ['puntEvaluador2'] = '0';
			
			$_REQUEST ['nomEvaluador3'] = "NULL";
			$_REQUEST ['uniEvaluador3'] = '0';
			$_REQUEST ['puntEvaluador3'] = '0';
			
			break;
		case '2' :
			
			$_REQUEST ['nomEvaluador1'];
			$_REQUEST ['uniEvaluador1'];
			$_REQUEST ['puntEvaluador1'];
			
			$_REQUEST ['nomEvaluador2'];
			$_REQUEST ['uniEvaluador2'];
			$_REQUEST ['puntEvaluador2'];
			
			$_REQUEST ['nomEvaluador3'] = "NULL";
			$_REQUEST ['uniEvaluador3'] = '0';
			$_REQUEST ['puntEvaluador3'] = '0';
			break;
		
		case '3' :
			
			$_REQUEST ['nomEvaluador1'];
			$_REQUEST ['uniEvaluador1'];
			$_REQUEST ['puntEvaluador1'];
			
			$_REQUEST ['nomEvaluador2'];
			$_REQUEST ['uniEvaluador2'];
			$_REQUEST ['puntEvaluador2'];
			
			$_REQUEST ['nomEvaluador3'];
			$_REQUEST ['uniEvaluador3'];
			$_REQUEST ['puntEvaluador3'];
			
			break;
	}
	
	
	$idEvaluadores = unserialize ( $_REQUEST ['idEvaluador'] );
	if ($resultado) {
		for($i = 1; $i <= 3; $i ++) {
			$arregloEvaluadores = array (
					$_REQUEST ['nomEvaluador' . $i],
					$_REQUEST ['uniEvaluador' . $i],
					$_REQUEST ['puntEvaluador' . $i] 
			);
			
			$this->cadena_sql = $this->sql->cadena_sql ( "actualizarEvaluador", $arregloEvaluadores,  $_REQUEST ['idCapitulo'], $idEvaluadores [$i] );
			$resultadoAutores = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
			
			$arregloLogEvento = array (
					'evaluador_capitulos',
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
			$this->funcion->redireccionar ( 'Actualizo', $_REQUEST ['idCapitulo'] );
		} else {
			$this->funcion->redireccionar ( 'noActualizo', $_REQUEST ['idCapitulo'] );
		}
	}
}
?>