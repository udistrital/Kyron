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
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'consultar_Perido_final' );
		
		$periodo = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
		$periodo = $periodo [0] ['max'];
		
		$arreglo = array (
				"funcionario" => $_REQUEST ['funcionario'],
				"id_elemento_individual" => $_REQUEST ['elemento_individual'],
				'observacion' => $_REQUEST ['descripcion'],
				"periodo" => $periodo 
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'Registrar_Observaciones_Elemento', $arreglo );
		
		$observacion = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda", $arreglo, "Registrar_Observaciones_Elemento" );

		$arreglo = array (
				$observacion [0] [0],
				$_REQUEST ['elemento_individual'] 
		);
		
		$arreglo = array (
				
				$_REQUEST ['placa'],
				$_REQUEST ['funcionario'],
				$_REQUEST ['elemento_individual'] 
		);
		
		if ($observacion) {
			
			redireccion::redireccionar ( 'insertoObservacion', $arreglo );
			exit ();
		} else {
			
			redireccion::redireccionar ( 'noInsertoObservacion', $_REQUEST ['funcionario'] );
			
			exit ();
		}
	}
}

$miRegistrador = new RegistradorOrden ( $this->lenguaje, $this->sql, $this->funcion );

$resultado = $miRegistrador->procesarFormulario ();

?>