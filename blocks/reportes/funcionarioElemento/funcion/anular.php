<?php

namespace inventarios\gestionElementos\modificarElemento\funcion;

use inventarios\gestionElementos\modificarElemento\funcion\redireccion;

include_once ('redireccionar.php');
if (! isset ( $GLOBALS ["autorizado"]funcionarioElemento/index.php");
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

		$arreglo=array(
			$_REQUEST['id_elemento'],
				$_REQUEST['observaciones']		
				
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'estado_elemento', $_REQUEST['id_elemento'] );
		
		$estado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "acceso" );
		

		
    
		$cadenaSql = $this->miSql->getCadenaSql ( 'anular_elemento', $arreglo );
		 
		$anular = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "acceso" );
		
		
				
		if ($anular) {
				
			redireccion::redireccionar ( 'anulado');
			exit();
		} else {
				
			redireccion::redireccionar ( 'noAnulado' );
			exit();
			
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

$miRegistrador = new RegistradorOrden ( $this->lenguaje, $this->sql, $this->funcion );

$resultado = $miRegistrador->procesarFormulario ();

?>