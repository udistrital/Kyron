<?php

namespace reportes\estadoDeCuenta\funcion;

use reportes\estadoDeCuenta\funcion\redireccionar;

include_once ('redireccionar.php');
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class EliminarRegistro {
	
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
		
		//$cadenaSql.=" llaves_primarias_valor ='" . $variable ['llaves_primarias_valor'] . "'";
		//var_dump($_REQUEST);
		$tabla = $_REQUEST['tabla'];
		$tabla = str_replace('\\\_', '_', $tabla);
		
		$condicion = $_REQUEST['condicion'];
		$condicion = str_replace('\\\_', '_', $condicion);
		$arregloDatos = array (
			'tabla' => $tabla,
			'condicion' => $condicion
		);
		//var_dump($arregloDatos);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'eliminar_de_tabla', $arregloDatos );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "actualizar" );
		
		if ($resultado) {
			redireccion::redireccionar ( 'actualizo',  $condicion );
			exit ();
		} else {
			redireccion::redireccionar ( 'noActualizo', $condicion );
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

$miRegistrador = new EliminarRegistro ( $this->lenguaje, $this->sql, $this->funcion );

$resultado = $miRegistrador->procesarFormulario ();

?>
