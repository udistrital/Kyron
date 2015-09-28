<?php

namespace asignacionPuntajes\salariales\estudiosPostDoctorales\funcion;

use asignacionPuntajes\salariales\estudiosPostDoctorales\funcion\redireccionar;

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
		
		if($_REQUEST['entidad']==''){
			$_REQUEST['entidad'] = 'null';
		}
		if (!isset($_REQUEST['otraEntidad'])){
			$_REQUEST['otraEntidad'] = null;
		}
		
		$arregloDatos = array (
			'id_docenteRegistrar' => $_REQUEST['id_docenteRegistrar'],
			'entidadInstitucion' => $_REQUEST['entidad'],
			'otraEntidad' => $_REQUEST['otraEntidad'],
			'tipoEntidad' => $_REQUEST['tipoEntidad'],
			'horasPorSemana' => $_REQUEST['horasPorSemana'],
			'fechaInicio' => $_REQUEST['fechaInicio'],
			'fechaFinalizacion' => $_REQUEST['fechaFinalizacion'],
			'duracionExperiencia' => $_REQUEST['duracionExperiencia'],
			'numeroActa' => $_REQUEST['numeroActa'],
			'fechaActa' => $_REQUEST['fechaActa'],
			'numeroCasoActa' => $_REQUEST['numeroCasoActa'],
			'puntaje' => $_REQUEST['puntaje'],
			'identificadorExperiencia' => $_REQUEST['identificadorExperiencia']
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'actualizar', $arregloDatos );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "actualizar" );

		if ($resultado) {
			redireccion::redireccionar ( 'actualizo',  $_REQUEST['docenteRegistrar']);
			exit ();
		} else {
			redireccion::redireccionar ( 'noActualizo',  $_REQUEST['docenteRegistrar']);
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
