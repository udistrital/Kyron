<?php

namespace inventarios\gestionElementos\funcionarioElemento\funcion;

use inventarios\gestionElementos\funcionarioElemento\funcion\redireccion;

include_once ('redireccionar.php');
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class RegistradorOrden {
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
		$conexion = "inventarios";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		for($i = 0; $i <= 10000; $i ++) {
			if (isset ( $_REQUEST ['item_' . $i] )) {
				$elementos [] = $_REQUEST ['item_' . $i];
			}
		}
		
		if (isset ( $elementos ) == false) {
			redireccion::redireccionar ( 'noSeleccion', array (
					$_REQUEST ['funcionario'],
					$_REQUEST ['usuario'] 
			) );
			
			
			exit;
		}
		
		if (isset ( $_REQUEST ['botonAprobar'] ) && $_REQUEST ['botonAprobar'] == 'Aprobar') {
			foreach ( $elementos as $valor ) {
				
				$cadenaSql = $this->miSql->getCadenaSql ( 'Elemento_Existencia_Aprobado', $valor );
				
				$estado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "acceso", $valor, "Elemento_Existencia_Aprobado" );
			}
			
			$mensaje = array (
					'Aprobado',
					$_REQUEST ['funcionario'] 
			);
		} elseif (isset ( $_REQUEST ['botonGuadar'] ) && $_REQUEST ['botonGuadar'] == 'Preaprobar') {
			
			$elemento = unserialize ( $_REQUEST ['id_elementos'] );
			
			foreach ( $elemento as $valor ) {
				
				$cadenaSql = $this->miSql->getCadenaSql ( 'Elemento_Existencia_Tipo_Confirmada', $valor );
				
				$estado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "acceso", $valor, "Elemento_Existencia_Tipo_Confirmada" );
			}
			
			if ($estado == true) {
				
				foreach ( $elementos as $valor ) {
					
					$cadenaSql = $this->miSql->getCadenaSql ( 'Elemento_Existencia_No_Aprovado', $valor );
					
					$estado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "acceso", $valor, "Elemento_Existencia_No_Aprovado" );
					
					$mensaje = array (
							'NoAprobado',
							$_REQUEST ['funcionario'] 
					);
				}
			}
		}
		$array = array (
				$_REQUEST ['usuario'] 
		);
		$mensaje = array_merge ( $mensaje, $array );
		
		if ($estado == true) {
			
			redireccion::redireccionar ( 'Verificacion', $mensaje );
			exit ();
		} else {
			
			redireccion::redireccionar ( 'noVerificado', array (
					$_REQUEST ['funcionario'],
					$_REQUEST ['usuario'] 
			) );
			exit ();
		}
	}
}

$miRegistrador = new RegistradorOrden ( $this->lenguaje, $this->sql, $this->funcion );

$resultado = $miRegistrador->procesarFormulario ();

?>