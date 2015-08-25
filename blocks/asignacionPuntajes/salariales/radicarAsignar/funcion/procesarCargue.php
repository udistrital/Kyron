<?php

namespace inventarios\radicarAsignar\funcion;

use inventarios\radicarAsignar\funcion\redireccion;

include_once ('redireccionar.php');
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class RegistradorAvance {
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
		$fechaActual = date ( 'Y-m-d' );
		
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
		
		$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "raizDocumento" ) . "/blocks/inventarios/";
		$rutaBloque .= $esteBloque ['nombre'];
		$host = $this->miConfigurador->getVariableConfiguracion ( "host" ) . $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/inventarios/" . $esteBloque ['nombre'];
		
		$conexion = "inventarios";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		foreach ( $_FILES as $key => $values ) {
			
			$archivo = $_FILES [$key];
		}
		
		if ($archivo ['name'] != '') {
			
			// obtenemos los datos del archivo
			$tamano = $archivo ['size'];
			$tipo = $archivo ['type'];
			$archivo1 = $archivo ['name'];
			$prefijo = substr ( md5 ( uniqid ( rand () ) ), 0, 6 );
			
			if ($archivo1 != "") {
				// guardamos el archivo a la carpeta files
				$destino1 = $rutaBloque . "/archivoSoporte/" . $prefijo . "_" . $archivo1;
				if (copy ( $archivo ['tmp_name'], $destino1 )) {
					$status = "Archivo subido: <b>" . $archivo1 . "</b>";
					$destino1 = $host . "/archivoSoporte/" . $prefijo . "_" . $archivo1;
				} else {
					$status = "Error al subir el archivo";
				}
			} else {
				$status = "Error al subir archivo";
			}
		}
		
		
		$arregloDatos = array (
				$fechaActual,
				$_REQUEST ['tipoCargue'],
				$_REQUEST ['numero_entrada'],
				$_REQUEST ['tipoDocumento'],
				(isset($_REQUEST ['tipoContrato'])==true)?$_REQUEST ['tipoContrato']:0,
				$archivo1,
				$destino1 
		);
		

	
		// consultar si la vigencia y la entrada existen
		$cadenaSql = $this->miSql->getCadenaSql ( 'registrarRadicacion', $arregloDatos );
		$Radicacion = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
		
		
		$datos = array (
				$Radicacion[0][0],
				$fechaActual 
		);
		
		if ($Radicacion!=false) {
			redireccion::redireccionar ( 'inserto', $datos );
		} else {
			redireccion::redireccionar ( 'noInserto', $datos );
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

$miRegistrador = new RegistradorAvance ( $this->lenguaje, $this->sql, $this->funcion );

$resultado = $miRegistrador->procesarFormulario ();
?>