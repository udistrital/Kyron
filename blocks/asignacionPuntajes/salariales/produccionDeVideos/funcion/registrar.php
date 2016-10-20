<?php

namespace asignacionPuntajes\salariales\produccionVideosDocente\funcion;

use asignacionPuntajes\salariales\produccionVideosDocente\funcion\redireccionar;

include_once ('redireccionar.php');
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class Registrar {
	
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
				
		$cadenaSql = $this->miSql->getCadenaSql ( 'registrar', $_REQUEST);
		$id_produccion_video = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
		
		for($i=1; $i<= $_REQUEST['numeroAutores']; $i++){
			$arregloEvaluador = array (
					'id_produccion_video' => $id_produccion_video[0]['id_produccion_video'],
					'nombreEvaluador' => $_REQUEST['nombreEvaluador'.$i],
					'UniversidadEvaluador' => $_REQUEST['universidadEvaluador'.$i],
					'puntajeEvaluador' => $_REQUEST['puntajeEvaluador'.$i]
			);
			
			$cadenaSql = $this->miSql->getCadenaSql ( 'registroEvaluador', $arregloEvaluador);
			$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "insertar" );
			
		}
		
		if ($resultado) {
			redireccion::redireccionar ( 'inserto',  $_REQUEST['docenteRegistrar']);
			exit ();
		} else {
			redireccion::redireccionar ( 'noInserto' );
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

$miRegistrador = new Registrar ( $this->lenguaje, $this->sql, $this->funcion );

$resultado = $miRegistrador->procesarFormulario ();

?>
