<?php

namespace asignacionPuntajes\salariales\direccionTrabajosDeGrado\funcion;

use asignacionPuntajes\salariales\direccionTrabajosDeGrado\funcion\redireccionar;

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
			if($_REQUEST['nombreEstudiante' . $i] != "" && $_REQUEST['codigoEstudiante' . $i]){
				$_REQUEST['numeroAutores']++;
			}
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
			'normatividad' => $_REQUEST['normatividad']
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'registrar', $arregloDatos );
		$id_direccion_trabajogrado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );

		
		for($i=1; $i<= $_REQUEST['numeroAutores']; $i++){
			$arregloEstudiante = array (
					'id_direccion_trabajogrado' => $id_direccion_trabajogrado[0]['id_direccion_trabajogrado'],
					'nombre_estudiante' => $_REQUEST['nombreEstudiante'.$i],
					'codigo_estudiante' => $_REQUEST['codigoEstudiante'.$i]
			);
			
			$cadenaSql = $this->miSql->getCadenaSql ( 'registroEstudiantes', $arregloEstudiante );
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
