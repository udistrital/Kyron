<?php

namespace asignacionPuntajes\salariales\experienciaCalificada\funcion;

use asignacionPuntajes\salariales\experienciaCalificada\funcion\redireccionar;

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
		
		$arregloDatos = array (
			'id_docenteRegistrar' => $_REQUEST['id_docenteRegistrar'],
			'tipoExperiencia' => $_REQUEST['tipoExperiencia'],
			'annioExperiencia' => $_REQUEST['annio_experiencia'],
			'numeroResolucion' => $_REQUEST['numeroResolucion'],
			'resolucionEmitidaPor' => $_REQUEST['resolucionEmitidaPor'],
			'annoResolucion' => $_REQUEST['fechaResolucion'],
			'numeroActa' => $_REQUEST['numeroActa'],
			'fechaActa' => $_REQUEST['fechaActa'],
			'puntaje' => $_REQUEST['puntaje'],
			'normatividad' => $_REQUEST['normatividad']
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'registrar', $arregloDatos );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "registrar" );
		
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
