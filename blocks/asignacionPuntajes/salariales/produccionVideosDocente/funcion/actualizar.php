<?php

namespace asignacionPuntajes\salariales\produccionVideosDocente\funcion;

use asignacionPuntajes\salariales\produccionVideosDocente\funcion\redireccionar;

include_once ('redireccionar.php');
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class RegistrarIndexacionRevista {
	
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miFuncion;
	var $miSql;
	var $conexion;
	
	function __construct($lenguaje, $sql, $funcion) {
		
		$this->miConfigurador = \Configurador::singleton ();
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		$this->lenguaje = $lenguaje;
		$this->miSql = $sql;
		$this->miFuncion = $funcion;
	}
	function procesarFormulario() {
		$conexion = "docencia";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
		
		$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "raizDocumento" ) . "/blocks/asignacionPuntajes/salariales/";
		$rutaBloque .= $esteBloque ['nombre'];
		$host = $this->miConfigurador->getVariableConfiguracion ( "host" ) . $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/asignacionPuntajes/salariales/" . $esteBloque ['nombre'];
		
		$_REQUEST['numeroAutores'] = 0;
		
		for($i=1; $i<=3; $i++){
			if($_REQUEST['nombreEvaluador' . $i] != "" && $_REQUEST['universidadEvaluador' . $i] != "" && $_REQUEST['puntajeEvaluador' . $i] != ""){
				$_REQUEST['numeroAutores']++;
			}
		}
		//Se consultan los evaluadores en la base de datos para comparar con lo que se desean regsitrar
		$cadena_sql = $this->miSql->getCadenaSql ( "publicacionEvaluadoresActualizar", $_REQUEST['identificadorProduccionVideo'] );
		$evaluadores = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );
			
		for($i=0; $i<count($evaluadores); $i++){
			$existeEvaluador = 0;
			for($j=1; $j<=3; $j++){
				if(!($evaluadores[$i]['nombre_evaluador']== $_REQUEST['nombreEvaluador'.$j] && $evaluadores[$i]['id_universidad']== $_REQUEST['universidadEvaluador'.$j] && $evaluadores[$i]['puntaje']== $_REQUEST['puntajeEvaluador'.$j])){
					if($evaluadores[$i]['nombre_evaluador']== $_REQUEST['nombreEvaluador'.$j] || $evaluadores[$i]['id_universidad']== $_REQUEST['universidadEvaluador'.$j] || $evaluadores[$i]['puntaje']== $_REQUEST['puntajeEvaluador'.$j]){
						$arregloEvaluador = array (
								'id_produccion_video' => $_REQUEST['identificadorProduccionVideo'],
								'old_nombre_evaluador' => $evaluadores[$i]['nombre_evaluador'],
								'old_id_universidad' => $evaluadores[$i]['id_universidad'],
								'old_puntaje_evaluador' => $evaluadores[$i]['puntaje'],
								'nombre_evaluador' => $_REQUEST['nombreEvaluador'.$j],
								'id_universidad' => $_REQUEST['universidadEvaluador'.$j],
								'puntaje_evaluador' => $_REQUEST['puntajeEvaluador'.$j]
						);
							
						$cadenaSql = $this->miSql->getCadenaSql ( 'actualizarEvaluador', $arregloEvaluador );
						$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "actualizar" );
						$existeEvaluador++;
					}else{
						$arregloEvaluador = array (
								'id_produccion_video' => $_REQUEST['identificadorProduccionVideo'],
								'nombre_evaluador' => $_REQUEST['nombreEvaluador'.$j],
								'id_universidad' => $_REQUEST['universidadEvaluador'.$j],
								'puntaje_evaluador' => $_REQUEST['puntajeEvaluador'.$j]
						);
							
						$cadenaSql = $this->miSql->getCadenaSql ( 'registroEvaluador', $arregloEvaluador );
						$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "insertar" );						
					}
				}else{
					$existeEvaluador++;
				}
			}
			if($existeEvaluador==0){
				$arregloEvaluador = array (
						'id_produccion_video' => $_REQUEST['identificadorProduccionVideo'],
						'old_nombre_evaluador' => $evaluadores[$i]['nombre_evaluador'],
						'old_id_universidad' => $evaluadores[$i]['id_universidad'],
						'old_puntaje_evaluador' => $evaluadores[$i]['puntaje']						
				);
					
				$cadenaSql = $this->miSql->getCadenaSql ( 'actualizarEvaluadorEliminar', $arregloEvaluador );
				$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "actualizar" );
			}
			
			$cadena_sql;
			var_dump($evaluadores); exit;
		}

		$arregloDatos = array (
			'id_docenteRegistrar' => $_REQUEST['id_docenteRegistrar'],
			'tituloTrabajo' => $_REQUEST['nombre'],
			'anno' => $_REQUEST['anno'],
			'tipoTrabajo' => $_REQUEST['tipo'],
			'categoriaTrabajo' => $_REQUEST['categoria'],
			'numeroAutores' => $_REQUEST['numeroAutores'],
			'numeroActa' => $_REQUEST['numeroActa'],
			'fechaActa' => $_REQUEST['fechaActa'],
			'numeroCasoActa' => $_REQUEST['numeroCasoActa'],
			'puntaje' => $_REQUEST['puntaje'],
			'id_direccion_trabajo' => $_REQUEST['identificadorDireccion']
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'actualizar', $arregloDatos );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "actualizar" );

		if ($resultado) {
			redireccion::redireccionar ( 'actualizo',  $_REQUEST['docenteRegistrar']);
			exit ();
		} else {
			redireccion::redireccionar ( 'noActualizo',  $_REQUEST['docenteRegistrar'] );
			exit ();
		}
	}
	
	function resetForm() {
		foreach ( $_REQUEST as $clave => $valor ) {
			
			if ($clave != 'pagina' && $clave != 'development' && $clave != 'jquery' && $clave != 'tiempo') {
				unset ( $_REQUEST [$clave] );
			}
		}
	}
}

$miRegistrador = new RegistrarIndexacionRevista ( $this->lenguaje, $this->sql, $this->funcion );

$resultado = $miRegistrador->procesarFormulario ();

?>
