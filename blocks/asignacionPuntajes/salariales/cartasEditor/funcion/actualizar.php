<?php

namespace asignacionPuntajes\salariales\cartasEditor\funcion;

use asignacionPuntajes\salariales\cartasEditor\funcion\redireccionar;

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
		
		$_REQUEST['numeroAutoresUniversidad'] = $this->nullify($_REQUEST['numeroAutoresUniversidad']);
		
		$arregloDatos = array (
			'id_docenteRegistrar' => $_REQUEST['id_docenteRegistrar'],
			'nombre' => $_REQUEST['nombre'],
			'contexto' => $_REQUEST['contexto'],
			'pais' => $_REQUEST['pais'],
			'categoria' => $_REQUEST['categoria'],
			'identificadorColeccion' => $_REQUEST['identificadorColeccion'],
			'anno' => $_REQUEST['anno'],
			'volumen' => $_REQUEST['volumen'],
			'numero' => $_REQUEST['numero'],
			'paginas' => $_REQUEST['paginas'],
			'tituloArticulo' => $_REQUEST['tituloArticulo'],
			'numeroAutores' => $_REQUEST['numeroAutores'],
			'numeroAutoresUniversidad' => $_REQUEST['numeroAutoresUniversidad'],
			'fechaPublicacion' => $_REQUEST['fechaPublicacion'],
			'numeroActa' => $_REQUEST['numeroActa'],
			'fechaActa' => $_REQUEST['fechaActa'],
			'numeroCasoActa' => $_REQUEST['numeroCasoActa'],
			'puntaje' => $_REQUEST['puntaje'],
			'normatividad' => $_REQUEST['normatividad'],
			'identificadorColeccion_old' => $_REQUEST['identificadorColeccion_old']
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
