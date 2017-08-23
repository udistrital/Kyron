<?php

namespace asignacionPuntajes\salariales\comunicacionCorta\funcion;

use asignacionPuntajes\salariales\comunicacionCorta\funcion\redireccionar;

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
	function nullify($param){
		if($param==''){
			return 'NULL';
		} else {
			return '\'' . $param . '\'';
		}
	}
	function procesarFormulario() {
		$conexion = "docencia";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
		
		$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "raizDocumento" ) . "/blocks/asignacionPuntajes/salariales/";
		$rutaBloque .= $esteBloque ['nombre'];
		$host = $this->miConfigurador->getVariableConfiguracion ( "host" ) . $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/asignacionPuntajes/salariales/" . $esteBloque ['nombre'];

		$_REQUEST['contextoRevista'] = 1;
		$_REQUEST['pais'] = 'COL';
		
		$_REQUEST['numeroAutoresUniversidad'] = $this->nullify($_REQUEST['numeroAutoresUniversidad']);
		
		$arregloDatos = array (
			'id_docenteRegistrar' => $_REQUEST['id_docenteRegistrar'],
			'nombreRevista' => $_REQUEST['nombreRevista'],
			'contextoRevista' => $_REQUEST['contextoRevista'],
			'pais' => $_REQUEST['pais'],
			'categoria' => $_REQUEST['categoria'],
			'issnRevista' => $_REQUEST['issnRevista'],
			'annoRevista' => $_REQUEST['annoRevista'],
			'volumenRevista' => $_REQUEST['volumenRevista'],
			'numeroRevista' => $_REQUEST['numeroRevista'],
			'paginasRevista' => $_REQUEST['paginasRevista'],
			'tituloArticuloRevista' => $_REQUEST['tituloArticuloRevista'],
			'numeroAutoresRevista' => $_REQUEST['numeroAutoresRevista'],
			'numeroAutoresUniversidad' => $_REQUEST['numeroAutoresUniversidad'],
			'numeroActaRevista' => $_REQUEST['numeroActaRevista'],
			'fechaActaRevista' => $_REQUEST['fechaActaRevista'],
			'numeroCasoActaRevista' => $_REQUEST['numeroCasoActaRevista'],
			'puntajeRevista' => $_REQUEST['puntajeRevista'],
			'normatividad' => $_REQUEST['normatividad'],
			'id_comunicacion_corta' => $_REQUEST['id_comunicacion_corta']
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

$miRegistrador = new Registrar ( $this->lenguaje, $this->sql, $this->funcion );

$resultado = $miRegistrador->procesarFormulario ();

?>
