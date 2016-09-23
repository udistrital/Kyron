<?php

namespace asignacionPuntajes\salariales\indexacionRevistas\funcion;

use asignacionPuntajes\salariales\indexacionRevistas\funcion\redireccionar;

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
		
		//Actualizar producción
		$cadenaSql = $this->miSql->getCadenaSql ('actualizarProduccion', $_REQUEST);
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "actualizar" );
		$transaccion = TRUE;
		$transaccion &= $resultado;
		
		for($i=1; $i<=3 && $transaccion; $i++){
			if(isset($_REQUEST['old_documentoEvaluador' . $i])){//Actualizar evaluador
				$datos = array(
						'documento_evaluador' =>  $_REQUEST ['documentoEvaluador'.$i],
						'old_documento_evaluador' =>  $_REQUEST ['old_documentoEvaluador'.$i],
						'numero_certificado' => $_REQUEST ['numeroCertificado'],
						'old_numero_certificado' => $_REQUEST ['old_numero_certificado'],
						'documento_docente' => $_REQUEST ['id_docenteRegistrar'],
						'old_documento_docente' => $_REQUEST ['old_id_docenteRegistrar'],
						'nombre' => $_REQUEST ['nombreEvaluador'.$i],
						'id_universidad' => $_REQUEST ['entidadCertificadora'.$i],
						'puntaje' => $_REQUEST ['puntajeSugeridoEvaluador'.$i]
				);
				$cadenaSql = $this->miSql->getCadenaSql ('actualizarEvaluador', $datos);
				$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "actualizar" );				
			} else if (isset($_REQUEST['documentoEvaluador' . $i]) && $_REQUEST['documentoEvaluador' . $i] != ''){//Insertar nuevo evaluador
				$datos = array(
						'documento_evaluador' =>  $_REQUEST ['documentoEvaluador'.$i],
						'numero_certificado' => $_REQUEST ['numeroCertificado'],
						'documento_docente' => $_REQUEST ['id_docenteRegistrar'],
						'nombre' => $_REQUEST ['nombreEvaluador'.$i],
						'id_universidad' => $_REQUEST ['entidadCertificadora'.$i],
						'puntaje' => $_REQUEST ['puntajeSugeridoEvaluador'.$i]
				);
				$cadenaSql = $this->miSql->getCadenaSql ('insertarEvaluador', $datos);
				$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "actualizar" );
			}
			$transaccion &= $resultado;
		}
		if ($transaccion==TRUE) {
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
